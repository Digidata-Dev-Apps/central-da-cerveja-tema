/**
 * Alpine.js App para Políticas de Frete
 *
 * @returns {Object} Objeto com dados e métodos do Alpine.js
 */

// Registre a diretiva antes de Alpine.start()
Alpine.directive("currency", (el, { expression }, { evaluate, effect }) => {
  const maskConfig = {
    prefix: "R$ ",
    fixed: true,
    fractionDigits: 2,
    decimalSeparator: ",",
    thousandsSeparator: ".",
    cursor: "end",
  };

  // Aplica a máscara
  SimpleMaskMoney.setMask(el, maskConfig);

  // Função para parsear o valor
  const parseCurrency = (value) => {
    if (!value) return 0;
    return value.replace("R$", "").replace(/\./g, "").replace(",", ".").trim();
  };

  // Atualiza o modelo quando o input muda
  el.addEventListener("input", () => {
    const cleanValue = parseCurrency(el.value);
    const numericValue = parseFloat(cleanValue) || 0;
    evaluate(`${expression} = ${numericValue}`);
  });

  // Observa mudanças no modelo
  effect(() => {
    const modelValue = evaluate(expression);
    if (modelValue === "" || modelValue === null) {
      el.value = "";
      return;
    }
    if (typeof modelValue === "number" && document.activeElement !== el) {
      el.value = SimpleMaskMoney.formatToNumber(
        modelValue.toString(),
        maskConfig
      );
    }
  });
});

function shippingPoliciesApp() {
  return {
    // Estado da aplicação
    policies: [],
    availableStates: [],
    loading: false,
    message: "",
    messageType: "success",
    initialized: false,

    // Instâncias do Cleave
    cleaveInstances: {},

    // Dados do novo formulário
    newPolicy: {
      state_code: "",
      discount_50_threshold: "",
      discount_75_threshold: "",
      discount_100_threshold: "",
    },

    /**
     * Inicializa a aplicação
     */
    async init() {
      if (this.initialized) return;
      this.initialized = true;
      await Promise.all([this.loadPolicies(), this.loadAvailableStates()]);
    },

    // Método para obter valores numéricos limpos
    getCleanValues() {
      return {
        state_code: this.newPolicy.state_code,
        discount_50_threshold: this.parseCurrency(
          this.newPolicy.discount_50_threshold
        ),
        discount_75_threshold: this.parseCurrency(
          this.newPolicy.discount_75_threshold
        ),
        discount_100_threshold: this.parseCurrency(
          this.newPolicy.discount_100_threshold
        ),
      };
    },

    /**
     * Carrega as políticas existentes
     */
    async loadPolicies() {
      this.loading = true;

      try {
        const response = await this.apiCall("sp_get_policies");

        if (response.success) {
          this.policies = response.data.data;
        } else {
          this.showMessage(
            response.data.message || shippingPoliciesAjax.i18n.errorGeneric,
            "error"
          );
        }
      } catch (error) {
        this.showMessage(shippingPoliciesAjax.i18n.errorGeneric, "error");
        console.error("Erro ao carregar políticas:", error);
      } finally {
        this.loading = false;
      }
    },

    /**
     * Carrega estados disponíveis
     */
    async loadAvailableStates() {
      try {
        const response = await this.apiCall("sp_get_available_states");

        if (response.success) {
          this.availableStates = response.data;
        }
      } catch (error) {
        console.error("Erro ao carregar estados:", error);
      }
    },

    /**
     * Adiciona nova política
     */
    async addPolicy() {
      // Realiza validação antes de fazer a requisição
      if (!this.isFormValid()) {
        return;
      }

      this.loading = true;

      try {
        const response = await this.apiCall(
          "sp_add_policy",
          this.getCleanValues()
        );

        if (response.success) {
          await Promise.all([this.loadPolicies(), this.loadAvailableStates()]);
          this.showMessage(shippingPoliciesAjax.i18n.successAdd, "success");
          this.resetForm();
        } else {
          this.showMessage(
            response.data.message || shippingPoliciesAjax.i18n.errorGeneric,
            "error"
          );
        }
      } catch (error) {
        this.showMessage(shippingPoliciesAjax.i18n.errorGeneric, "error");
        console.error("Erro ao adicionar política:", error);
      } finally {
        this.loading = false;
      }
    },

    /**
     * Remove política
     *
     * @param {string} uuid Código do estado
     */
    async deletePolicy(uuid) {
      if (!confirm(shippingPoliciesAjax.i18n.confirmDelete)) {
        return;
      }

      this.loading = true;

      try {
        const response = await this.apiCall("sp_delete_policy", {
          uuid: uuid,
        });

        if (response.success) {
          await Promise.all([this.loadPolicies(), this.loadAvailableStates()]);
          this.showMessage(shippingPoliciesAjax.i18n.successDelete, "success");
        } else {
          this.showMessage(
            response.data.message || shippingPoliciesAjax.i18n.errorGeneric,
            "error"
          );
        }
      } catch (error) {
        this.showMessage(shippingPoliciesAjax.i18n.errorGeneric, "error");
        console.error("Erro ao remover política:", error);
      } finally {
        this.loading = false;
      }
    },

    /**
     * Exibe mensagem de feedback
     * @param {string} text Texto da mensagem
     * @param {string} type Tipo da mensagem (success/error)
     */
    showMessage(text, type = "success") {
      this.message = text;
      this.messageType = type;
      // Auto-ocultar após 5 segundos
      setTimeout(() => {
        this.message = "";
      }, 5000);
    },

    /** Formata valor como moeda
     * @param {number} value Valor a formatar
     * @returns {string}
     */
    formatCurrency(value) {
      return new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL",
      }).format(value);
    },

    parseCurrency(value) {
      if (typeof value !== "string") return value;

      // Remove R$, espaços e pontos de milhar
      let cleaned = value
        .replace(/R\$\s?/, "")
        .replace(/\./g, "")
        .replace(",", ".");

      // Converte para float
      const parsed = parseFloat(cleaned);

      return isNaN(parsed) ? 0 : parsed;
    },

    onMoneyInput(event, field) {
      const rawValue = event.target.value;
      const parsed = this.parseCurrency(rawValue);
      this.newPolicy[field] = this.formatCurrency(parsed);
    },

    /**
     * Valida o formulário
     *
     * @returns {boolean}
     */
    isFormValid() {
      const errors = [];
      const {
        state_code,
        discount_50_threshold,
        discount_75_threshold,
        discount_100_threshold,
      } = this.newPolicy;

      // Valida estado
      if (!state_code) {
        errors.push("Por favor, selecione um estado.");
      }

      // Converte valores para números
      const discount50 = this.parseCurrency(discount_50_threshold);
      const discount75 = this.parseCurrency(discount_75_threshold);
      const discount100 = this.parseCurrency(discount_100_threshold);

      // Valida se os valores são positivos e maiores que zero
      if (discount50 <= 0) {
        errors.push("O desconto de 50% deve ser maior que zero.");
      }

      if (discount75 <= 0) {
        errors.push("O desconto de 75% deve ser maior que zero.");
      }

      if (discount100 <= 0) {
        errors.push("O desconto de 100% deve ser maior que zero.");
      }

      // Valida a progressão dos valores (50% < 75% < 100%)
      if (discount50 >= discount75) {
        errors.push("O desconto de 75% deve ser maior que o desconto de 50%.");
      }

      if (discount75 >= discount100) {
        errors.push("O desconto de 100% deve ser maior que o desconto de 75%.");
      }

      // Exibe erros se houver
      if (errors.length > 0) {
        //this.showValidationErrors(errors);
        return false;
      }

      return true;
    },

    /**
     * Exibe erros de validação do formulário
     *
     * @param {Array} errors Lista de erros a exibir
     */
    showValidationErrors(errors) {
      // Seleciona o formulário ou o container pai onde os erros serão exibidos
      const formDiv = document.querySelector(".shipping-policies-form");

      // Verifica se o elemento pai existe
      if (!formDiv) {
        console.error(
          "O elemento '.shipping-policies-form' não foi encontrado no DOM."
        );
        return; // Evita o erro se o elemento não existir
      }

      // Seleciona ou cria o container de erros
      let errorContainer = document.querySelector(".validation-errors");

      if (!errorContainer) {
        // Caso não exista, cria um novo container
        errorContainer = document.createElement("div");
        errorContainer.className = "validation-errors notice notice-error";
        formDiv.insertBefore(errorContainer, formDiv.firstChild); // Insere antes do conteúdo do formulário
      }

      // Atualiza o conteúdo do container de erros
      errorContainer.innerHTML = `<ul>${errors
        .map((error) => `<li>${error}</li>`)
        .join("")}</ul>`;
      errorContainer.style.display = "block";

      // Rola até o container de erros para chamar atenção do usuário
      errorContainer.scrollIntoView({ behavior: "smooth", block: "start" });
    },

    /**
     * Remove mensagens de validação
     */
    clearValidationErrors() {
      const errorContainer = document.querySelector(".validation-errors");
      if (errorContainer) {
        errorContainer.style.display = "none";
        errorContainer.innerHTML = "";
      }
    },

    /**
     * Reseta o formulário
     */
    resetForm() {
      this.newPolicy = {
        state_code: "",
        discount_50_threshold: "",
        discount_75_threshold: "",
        discount_100_threshold: "",
      };

      this.clearValidationErrors();
    },

    /**
     * Faz chamada AJAX
     *
     * @param {string} action Ação do AJAX
     * @param {Object} data Dados adicionais
     * @returns {Promise}
     */
    async apiCall(action, data = {}) {
      const formData = new FormData();
      formData.append("action", action);
      formData.append("nonce", shippingPoliciesAjax.nonce);

      // Adiciona dados extras
      for (const key in data) {
        formData.append(key, data[key]);
      }

      const response = await fetch(shippingPoliciesAjax.ajaxurl, {
        method: "POST",
        body: formData,
      });

      return await response.json();
    },
  };
}
