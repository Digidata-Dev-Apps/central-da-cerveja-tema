var ContactPhoneIsValid = true;
var ContactEmailIsValid = true;

(function ($) {

  function messages() {
    return {
      required: "Este campo &eacute; obrigat&oacute;rio.",
      remote: "Por favor, corrija este campo.",
      email:
        "Por favor, forne&ccedil;a um endere&ccedil;o eletr&ocirc;nico v&aacute;lido.",
      url: "Por favor, forne&ccedil;a uma URL v&aacute;lida.",
      date: "Por favor, forne&ccedil;a uma data v&aacute;lida.",
      dateISO: "Por favor, forne&ccedil;a uma data v&aacute;lida (ISO).",
      number: "Por favor, forne&ccedil;a um n&uacute;mero v&aacute;lido.",
      digits: "Por favor, forne&ccedil;a somente d&iacute;gitos.",
      creditcard:
        "Por favor, forne&ccedil;a um cart&atilde;o de cr&eacute;dito v&aacute;lido.",
      equalTo: "Por favor, forne&ccedil;a o mesmo valor novamente.",
      accept:
        "Por favor, forne&ccedil;a um valor com uma extens&atilde;o v&aacute;lida.",
      maxlength: jQuery.validator.format(
        "Por favor, forne&ccedil;a n&atilde;o mais que {0} caracteres.",
      ),
      minlength: jQuery.validator.format(
        "Por favor, forne&ccedil;a ao menos {0} caracteres.",
      ),
      rangelength: jQuery.validator.format(
        "Por favor, forne&ccedil;a um valor entre {0} e {1} caracteres de comprimento.",
      ),
      range: jQuery.validator.format(
        "Por favor, forne&ccedil;a um valor entre {0} e {1}.",
      ),
      max: jQuery.validator.format(
        "Por favor, forne&ccedil;a um valor menor ou igual a {0}.",
      ),
      min: jQuery.validator.format(
        "Por favor, forne&ccedil;a um valor maior ou igual a {0}.",
      ),
      cpfBR: "CPF inv&aacute;lido.",
    };
  }

  

  $(document).ready(function () {
    $.validator.addMethod(
      "valid_phone",
      function (value, element, param) {
        var Phone;
        if ($("body").hasClass("page-template-contact-us")) {
          var Phone = $("#contact_us_phone").val();
        } else if ($("body").hasClass("page-template-my-barrel")) {
          var Phone = $("#my_barrel_phone").val();
        } else if ($("body").hasClass("woocommerce-account")) {
          var Phone = $("#phone").val();
        } else if ($("body").hasClass("page-template-clube-pre-venda")) {
          var Phone = $("#clube_email_notification_phone").val();
        }

        PhoneIsValid = validatePhone(value);

        if (Phone.length > 0) {
          if (PhoneIsValid) {
            return true;
          } else {
            return false;
          }
        }
      },
      "Telefone inválido.",
    );

    $.validator.addMethod(
      "valid_register_password",
      function (value, element, param) {
        if ($("body").hasClass("woocommerce-account")) {
          var Password = $("#register_password").val();
        }

        if (
          Password.length > 7 &&
          Password.match(/([a-z])/) &&
          Password.match(/([A-Z])/) &&
          Password.match(/([0-9])/) &&
          Password.match(/([!,%,&,@,#,$,^,*,?,_,(,),~])/)
        ) {
          $(".password-tip").text("");
          return true;
        } else {
          $(".password-tip").text(
            'Dica: A senha deve ter pelo menos oito caracteres. Para torná-la mais forte, use letras maiúsculas e minúsculas, números e símbolos como ! " ? $ % ^ & ).',
          );
          return false;
        }
      },
      "Senha inválida.",
    );

    $.validator.addMethod(
      "valid_email",
      function (value, element, param) {
        var Email;

        if ($("body").hasClass("page-template-contact-us")) {
          var Email = $("#contact_us_email").val();
        } else if ($("body").hasClass("page-template-my-barrel")) {
          var Email = $("#my_barrel_email").val();
        } else if ($("body").hasClass("page-template-clube-pre-venda")) {
          var Email = $("#clube_email_notification_email").val();
        }

        EmailIsValid = validateEmail(value);

        if (Email.length > 0) {
          if (EmailIsValid) {
            return true;
          } else {
            return false;
          }
        }
      },
      "Email inválido.",
    );

    $(document)
      .find("#woocommerce_register")
      .validate({
        rules: {
          register_password: {
            valid_register_password: true,
          },
          password_confirm: {
            equalTo: "#register_password",
          },
          phone: {
            valid_phone: true,
          },
          cpf: {
            cpfBR: true,
          },
        },
      });

    var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, "").length === 11
          ? "(00) 00000-0000"
          : "(00) 0000-00009";
      },
      spOptions = {
        onKeyPress: function (val, e, field, options) {
          field.mask(SPMaskBehavior.apply({}, arguments), options);
        },
      };

    $("#phone").mask(SPMaskBehavior, spOptions);
    $("#mobile").mask(SPMaskBehavior, spOptions);
    $("#account_email").prop("readonly", true);

    $("#button_verify").on("click", function () {
      $.ajax({
        url: cdc_user.ajax_url,
        type: "POST",
        dataType: "JSON",
        data: {
          action: "user_email_check",
          email: $("#email_check").val(),
        },
        beforeSend: function () {
          $(".woocommerce_regiter_verify").block({
            message: null,
            overlayCSS: {
              background: "#fff",
              opacity: 0.6,
            },
          });
        },
        success: function (response) {
          if (response.status) {
            if (response.exists) {
              $(".woocommerce-notices-wrapper").html(response.message);
            } else {
              $(".woocommerce-notices-wrapper").html(null);
              $("#form_auth_register_check").hide();
              $("#form_register").show();
              $("#email").val($("#email_check").val());
            }
          } else {
            $(".woocommerce-notices-wrapper").html(response.message);
          }
          $(".woocommerce_regiter_verify").unblock();
        },
      });
    });

    $(document)
      .find("#cpf")
      .on("keyup", function () {
        if ($("#cpf").val() == "" || $("#cpf").val() == null) return;
        if ($("#cpf").val().length == 14) {
          $.ajax({
            url: cdc_user.ajax_url,
            type: "POST",
            dataType: "JSON",
            data: {
              action: "check_for_registered_cpf",
              cpf: $("#cpf").val(),
            },
            success: function (response) {
              if (response.status) {
                if (response.cpf_registered) {
                  $("#cpf_exists").remove();
                  $("#cpf").addClass("cpf_registered");
                  $("#cpf").parent().append(`
                  <label id="cpf_exists" for="cpf">CPF já cadastrado.</label>
                `);
                } else {
                  $("#cpf").removeClass("cpf_registered");
                  $("#cpf_exists").remove();
                }
              }
            },
          });
        } else {
          $("#cpf").removeClass("cpf_registered");
          $("#cpf_exists").remove();
        }
      });

    $("#btn_register").on("click", function (e) {
      e.preventDefault();

      const $form = $("#woocommerce_register");
      const $btn = $(this);
      const $msgBox = $("#register_message");

      if ($btn.prop("disabled")) return;

      $msgBox.stop(true).hide().removeClass("error success").text("");

      if (!$form.valid()) {
        showMessage("Preencha todos os campos obrigatórios corretamente.", "error");
        return;
      }

      if ($("#cpf").hasClass("cpf_registered")) {
        showMessage("O CPF informado já está cadastrado no sistema.", "error");
        return;
      }

      const formData = {
        action: "user_register",
        first_name: $("#first_name").val(),
        last_name: $("#last_name").val(),
        email: $("#email").val(),
        password: $("#register_password").val(),
        cpf: $("#cpf").val(),
        phone: $("#phone").val(),
        mobile: $("#mobile").val(),
        postcode: $("#postcode").val(),
        address: $("#address").val(),
        number: $("#number").val(),
        complement: $("#complement").val(),
        county: $("#county").val(),
        city: $("#city").val(),
        state: $("#state").val(),
        woocommerce_nonce: $("#woocommerce-register-nonce").val(),
      };

      $.ajax({
        url: cdc_user.ajax_url,
        type: "POST",
        dataType: "json",
        data: formData,
        beforeSend: function () {
          $btn.prop("disabled", true).text("Cadastrando...");
          $form.block({
            message: null,
            overlayCSS: { background: "#fff", opacity: 0.6 },
          });
        },
        success: function (response) {
          $form.unblock();
          $btn.prop("disabled", false).text("Cadastrar");

          if (response.success && response.data?.status) {
            showMessage(response.data.message || "Cadastro realizado com sucesso, redirecionado...", "success");
            setTimeout(() => {
              window.location.href = "/";
            }, 1200);
          } else {
            const msg =
              response.data?.message ||
              "Não foi possível concluir o cadastro. Verifique os dados e tente novamente.";
            showMessage(msg, "error");
          }
        },
        error: function (xhr, status, error) {
          $form.unblock();
          $btn.prop("disabled", false).text("Cadastrar");

          let msg = "Erro inesperado. Verifique sua conexão e tente novamente.";
          if (xhr.responseJSON?.data?.message) {
            msg = xhr.responseJSON.data.message;
          } else if (error) {
            msg = `Erro: ${error}`;
          }

          showMessage(msg, "error");
        },
      });

      /**
       * Exibe uma mensagem no topo do formulário.
       * @param {string} text - Mensagem a ser exibida
       * @param {string} type - 'success' ou 'error'
       */
      function showMessage(text, type) {
        const color = type === "success" ? "#2f855a" : "#c53030";
        $msgBox
          .text(text)
          .css({
            color: "#fff",
            background: color,
            padding: "10px 14px",
            borderRadius: "6px",
            marginBottom: "10px",
            display: "none",
          })
          .fadeIn(200);
      }
    });


    $("#postcode").blur(function () {
      var cep = $(this).val().replace(/\D/g, "");
      if (cep != "") {
        var validacep = /^[0-9]{8}$/;
        if (validacep.test(cep)) {
          $("#address").val("...");
          $("#county").val("...");
          $("#city").val("...");

          $.getJSON(
            "https://viacep.com.br/ws/" + cep + "/json/?callback=?",
            function (dados) {
              if (!("erro" in dados)) {
                $("#address").val(dados.logradouro).valid();
                $("#county").val(dados.bairro).valid();
                $("#city").val(dados.localidade).valid();
                $("#state").val(dados.uf).valid();
              } else {
                clear_register_form();
                $(".woocommerce-notices-wrapper").html(
                  `<div class="woocommerce-info">Cep não encontrado!</div>`,
                );
              }
            },
          );
        } else {
          clear_register_form();
          $(".woocommerce-notices-wrapper").html(
            `<div class="woocommerce-info">Cep inválido!</div>`,
          );
        }
      } else {
        clear_register_form();
      }
    });
    find_postcode_cart();
    show_addres_cart();
    jQuery(document.body).on("updated_cart_totals", function () {
      find_postcode_cart();
      show_addres_cart();
    });

    var lastCepBilling = "";
    var lastCepShipping = "";

    $("#billing_postcode").on("keyup", function () {
      var cep = $(this).val().replace(/\D/g, "");

      if (cep.length != 8) return;
      if (cep == lastCepBilling) return;

      lastCepBilling = cep;
      searchAddress(cep, "billing");
    });

    $("#shipping_postcode").on("keyup", function () {
      var cep = $(this).val().replace(/\D/g, "");

      if (cep.length != 8) return;
      if (cep == lastCepShipping) return;

      lastCepShipping = cep;
      searchAddress(cep, "shipping");
    });

    function searchAddress(cep, type) {
      var validacep = /^[0-9]{8}$/;

      if (!validacep.test(cep)) {
        clearDeliveryForm(type);
        $(".woocommerce-notices-wrapper").html(
          `<div class="woocommerce-info">Cep inválido!</div>`
        );
        return;
      }

      $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {
        if (!("erro" in dados)) {
          $(`#${type}_address_1`).val(dados.logradouro);
          $(`#${type}_neighborhood`).val(dados.bairro);
          $(`#${type}_city`).val(dados.localidade);
          $(`#${type}_state`).val(dados.uf).trigger("change");
          return;
        }

        clearDeliveryForm(type);
        $(".woocommerce-notices-wrapper").html(
          `<div class="woocommerce-info">Cep não encontrado!</div>`
        );
      });
    }

    function clearDeliveryForm(type) {
      if (type === "billing") {
        clear_billing_form();
      } else {
        clear_shipping_form();
      }
    }

    function clear_register_form() {
      $("#address").val(null);
      $("#number").val(null);
      $("#complement").val(null);
      $("#county").val(null);
      $("#city").val(null);
      $("#state").val(null);
    }

    function clear_billing_form() {
      $("#billing_address_1").val(null);
      $("#billing_neighborhood").val(null);
      $("#billing_city").val(null);
      $("#billing_state").val(null);
    }

    function clear_shipping_form() {
      $("#shipping_address_1").val(null);
      $("#shipping_neighborhood").val(null);
      $("#shipping_city").val(null);
      $("#shipping_state").val(null);
    }

    function find_postcode_cart() {
      if (
        $("#calc_shipping_city").val() == null ||
        $("#calc_shipping_city").val() == ""
      ) {
        $(".checkout-button").prop("href", "javascript:void(0);");
        $(".checkout-button").css("cursor", "no-drop");
      } else {
        $(".checkout-button").prop("href", "/finalizar-compra");
        $(".checkout-button").css("cursor", "pointer");
      }

      $(document).find("#calc_shipping_postcode").mask("00000-000");

      $(document).on(
        "keyup keypress keydown",
        ".woocommerce-shipping-calculator",
        function (event) {
          if (event.keyCode === 13) {
            event.preventDefault();
            return false;
          }
        },
      );

      $(document)
        .find("#calc_shipping_postcode")
        .on("keyup", function (event) {
          if (event.keyCode === 13) {
            event.preventDefault();
            return false;
          }
          updated_cart_totals_order_gift();
          if (this.value.length == 9) {
            var cep = $(this).val().replace(/\D/g, "");
            if (cep != "") {
              var validacep = /^[0-9]{8}$/;
              if (validacep.test(cep)) {
                $.getJSON(
                  "https://viacep.com.br/ws/" + cep + "/json/?callback=?",
                  function (dados) {
                    if (!("erro" in dados)) {
                      $("#calc_shipping_state").val(dados.uf);
                      $("#calc_shipping_city").val(dados.localidade);
                      localStorage.setItem("address", JSON.stringify(dados));
                      $(".woocommerce-shipping-calculator").submit();
                    } else {
                      $("#calc_shipping_state").val(null);
                      $("#calc_shipping_city").val(null);
                      localStorage.removeItem("address");
                      $("#shipping_method").html(
                        '<div><span class="text-danger">CEP Inválido.</span></div>',
                      );
                    }
                  },
                );
              } else {
                $("#calc_shipping_state").val(null);
                $("#calc_shipping_city").val(null);
                $("#shipping_method").html(
                  '<div><span class="text-danger">CEP Inválido.</span></div>',
                );
                localStorage.removeItem("address");
              }
            } else {
              $("#calc_shipping_state").val(null);
              $("#calc_shipping_city").val(null);
              $("#shipping_method").html(
                '<div><span class="text-danger">CEP Obrigatório.</span></div>',
              );
              localStorage.removeItem("address");
            }
          }
        });
    }

    async function show_addres_cart() {
      var address = localStorage.getItem("address");

      var response = await $.post(`${cdc_user.ajax_url}`, {
        action: "logged_user",
      });

      if (address != null) {
        if (
          address.length > 0 &&
          $("#calc_shipping_city").val() != "" &&
          response.is_logged &&
          response.is_avaible
        ) {
          address = JSON.parse(address);
          $("#shipping_address").text(
            `Entregar para: ${address.logradouro}, ${address.bairro}, ${address.localidade} - ${address.uf}`,
          );
          return;
        }
      }
      $("#shipping_address").text("");
      return;
    }

    if ($("body").hasClass("woocommerce-order-received")) {
      sessionStorage.removeItem("gift_data");
    }

    function reload_page_gift_order() {
      var gift_data = sessionStorage.getItem("gift_data");

      if (gift_data != null && gift_data.length > 0) {
        gift_data = JSON.parse(gift_data);
        $("#gift_order").prop("checked", true);
        $(".gift-order-div").css("display", "block");
        $("#gift_from").val(gift_data.gift_from);
        $("#gift_to").val(gift_data.gift_to);
        $("#gift_message").val(gift_data.gift_message);
      }
    }
    reload_page_gift_order();

    function order_is_a_gift_dropdown() {
      $("#gift_order").on("click", function () {
        if ($("#gift_order").is(":checked")) {
          $(".gift-order-div").slideDown();
        } else {
          sessionStorage.removeItem("gift_data");
          $(".gift-order-div").slideUp();
        }
      });
    }
    order_is_a_gift_dropdown();

    function validate_gift_order_fields(event) {
      if ($("#gift_order:checked").is(":checked")) {
        if ($("#gift_from").val() == "") {
          event.preventDefault();
          $("#error_gift_from").remove();
          $("#gift_from").focus();
          $("#gift_from")
            .parent()
            .append(
              '<span id="error_gift_from" class="error-gift">Campo obrigatório</span>',
            );
        }

        if ($("#gift_to").val() == "") {
          event.preventDefault();
          $("#error_gift_to").remove();
          $("#gift_to").focus();
          $("#gift_to")
            .parent()
            .append(
              '<span id="error_gift_to" class="error-gift">Campo obrigatório</span>',
            );
        }

        if ($("#gift_message").val() == "") {
          event.preventDefault();
          $("#error_gift_message").remove();
          $("#gift_message").focus();
          $("#gift_message")
            .parent()
            .append(
              '<span id="error_gift_message" class="error-gift">Campo obrigatório</span>',
            );
        }

        if (
          $("#gift_from").val().length > 0 &&
          $("#gift_to").val().length > 0 &&
          $("#gift_message").val().length > 0
        ) {
          var values = {
            gift_from: $("#gift_from").val(),
            gift_to: $("#gift_to").val(),
            gift_message: $("#gift_message").val(),
          };
          sessionStorage.setItem("gift_data", JSON.stringify(values));
        }
      }
    }

    function updated_cart_totals_order_gift() {
      var gift_data = sessionStorage.getItem("gift_data");
      if (
        gift_data == null &&
        $("#gift_from").val().length > 0 &&
        $("#gift_to").val().length > 0 &&
        $("#gift_message").val().length > 0
      ) {
        var values = {
          gift_from: $("#gift_from").val(),
          gift_to: $("#gift_to").val(),
          gift_message: $("#gift_message").val(),
        };
        sessionStorage.setItem("gift_data", JSON.stringify(values));
      }
    }

    $(document.body).on("updated_cart_totals", function (event) {
      updated_cart_totals_order_gift();
      order_is_a_gift_dropdown();
      reload_page_gift_order();

      $(".checkout-button").on("click", function (event) {
        validate_gift_order_fields(event);
      });
    });

    $(".actions .coupon .button, .actions .button").on("click", function () {
      updated_cart_totals_order_gift();
    });

    $(".checkout-button").on("click", function (event) {
      validate_gift_order_fields(event);
    });

    if ($("body").hasClass("woocommerce-checkout")) {
      var gift_data = sessionStorage.getItem("gift_data");
      if (gift_data != null && gift_data.length > 0) {
        gift_data = JSON.parse(gift_data);
        $("#ship-to-different-address-checkbox").trigger("click");
        $("#shipping_gift_order").val("1");
        $("#shipping_gift_from").val(gift_data.gift_from);
        $("#shipping_gift_to").val(gift_data.gift_to);
        $("#shipping_gift_message").val(gift_data.gift_message);
      } else {
        $("#shipping_gift_order").val(null);
        $("#shipping_gift_from").val(null);
        $("#shipping_gift_to").val(null);
        $("#shipping_gift_message").val(null);
      }
    }

    function load_postcode() {
      var address = localStorage.getItem("address");
      if (
        $("#billing_postcode").val() != null ||
        $("#billing_postcode").val() != "" ||
        (address != null && address.length > 0)
      ) {
        $("#billing_postcode").blur();
      }

      if (
        $("#shipping_postcode").val() != null ||
        $("#shipping_postcode").val() != ""
      ) {
        $("#shipping_postcode").blur();
      }

      if ($("#shipping_postcode").val() != $("#billing_postcode").val()) {
        $("#ship-to-different-address-checkbox").trigger("click");
      }
    }
    load_postcode();

    function validatePhone(phone) {
      var regex = new RegExp(
        /^(?:(?:\+|00)?(55)\s?)?(?:\(?([1-9][0-9])\)?\s?)?(?:((?:9\d|[2-9])\d{3})\-?(\d{4}))$/,
      );
      return regex.test(phone);
    }

    function validateEmail(email) {
      var regex =
        /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      return regex.test(email);
    }

    $("#contact-us-form").validate({
      rules: {
        contact_us_name: {
          required: true,
        },
        contact_us_phone: {
          required: true,
          valid_phone: true,
        },
        contact_us_email: {
          required: true,
          valid_email: true,
        },
        contact_us_subject: {
          required: true,
        },
        contact_us_message: {
          required: true,
        },
      },
    });
    $("#contact_us_phone").mask(SPMaskBehavior, spOptions);

    $("#contact-us-form").on("submit", function (event) {
      event.preventDefault();
      if (
        $("#contact-us-form").valid() &&
        ContactPhoneIsValid &&
        ContactEmailIsValid
      ) {
        $.ajax({
          type: "POST",
          dataType: "JSON",
          url: cdc_user.ajax_url,
          data: {
            action: "cdc_contact_us",
            name: $("#contact_us_name").val(),
            phone: $("#contact_us_phone").val(),
            email: $("#contact_us_email").val(),
            subject: $("#contact_us_subject").val(),
            message: $("#contact_us_message").val(),
            logged_user: $("#logged_user").val(),
            woocommerce_nonce: $("#woocommerce-contact-us-nonce").val(),
            token: $("#generate_token").val(),
          },
          success: function (response) {
            if (response.status) {
              $("#contact-us-form").html(null);
              $(".send-your-thoughts").html(null);
              $(".contact-us-div").html(`
                <div>
                  <p class="mt-3 mb-3" style="font-family: 'Gotham bold'; color: #535353;">Mensagem enviada com sucesso.</p>
                  <p class="mb-3" style="font-family: 'Gotham bold'; color: #535353;">Logo entraremos em contato.</p>

                  <a href="/contato" class="btn" style="font-family: 'Gotham bold'; background: #f8a924; color: white; border-radius: 20px;">Retornar</a>
                </div>
              `);
            } else {
              $("#contact-us-form").html(null);
              $(".send-your-thoughts").html(null);
              $(".contact-us-div").html(`
                <div>
                  <p class="mt-3 mb-3" style="font-family: 'Gotham bold'; color: #535353;">Falha ao enviar mensagem.</p>
                  <p class="mb-3" style="font-family: 'Gotham bold'; color: #535353;">Por favor, tente novamente.</p>

                  <a href="/contato" class="btn" style="font-family: 'Gotham bold'; background: #f8a924; color: white; border-radius: 20px;">Retornar</a>
                </div>
              `);
            }
          },
        });
      }
    });

    $.extend($.validator.messages, messages());
    $("#barrel-request-form").validate({
      rules: {
        my_barrel_name: {
          required: true,
        },
        my_barrel_phone: {
          required: true,
          valid_phone: true,
        },
        my_barrel_email: {
          required: true,
          valid_email: true,
        },
        my_barrel_delivery_date: {
          required: true,
        },
        my_barrel_state: {
          required: true,
        },
        my_barrel_city: {
          required: true,
        },
        my_barrel_request_info: {
          required: true,
        },
        my_barrel_liters: {
          required: true,

        },
      },
      messages: {
        my_barrel_liters: {
          required: "Campo obrigatório",
        }
      }
    });
    $("#my_barrel_phone").mask(SPMaskBehavior, spOptions);

    $("#barrel-request-form").on("submit", function (event) {
      event.preventDefault();
      if ($("#barrel-request-form").valid() && PhoneIsValid && EmailIsValid) {
        $.ajax({
          type: "POST",
          dataType: "JSON",
          url: cdc_user.ajax_url,
          data: {
            action: "barrel_request",
            name: $("#my_barrel_name").val(),
            phone: $("#my_barrel_phone").val(),
            email: $("#my_barrel_email").val(),
            delivery_date: $("#my_barrel_delivery_date").val(),
            order_date: new Date().toLocaleString(),
            state: $("#my_barrel_state").val(),
            city: $("#my_barrel_city").val(),
            request_info: $("#my_barrel_request_info").val(),
            user_id: $("#user_id").val(),
            suppliers: $("#my_barrel_prefer-supplier").select2("val"),
            woocommerce_nonce: $("#woocommerce-barrel-request-nonce").val(),
            liters: $("#my_barrel_liters").val(),
            style: $("#my_barrel_chop-style").val(),
          },
          success: function (response) {
            if (response.status) {
              $("#barrel-request-form").html(null);
              $(".request-your-barrel").html(null);
              $(".barrel-request-div").html(`
                <div>
                  <p class="mt-3 mb-3" style="font-family: 'Gotham bold'; color: #535353;">Mensagem enviada com sucesso.</p>
                  <p class="mb-3" style="font-family: 'Gotham bold'; color: #535353;">Logo entraremos em contato.</p>

                  <a href="/meu-barril" class="btn" style="font-family: 'Gotham bold'; background: #f8a924; color: white; border-radius: 20px;">Retornar</a>
                </div>
              `);
            } else {
              $("#barrel-request-form").html(null);
              $(".request-your-barrel").html(null);
              $(".barrel-request-div").html(`
                <div>
                  <p class="mt-3 mb-3" style="font-family: 'Gotham bold'; color: #535353;">Falha ao enviar mensagem.</p>
                  <p class="mb-3" style="font-family: 'Gotham bold'; color: #535353;">Por favor, tente novamente.</p>

                  <a href="/meu-barril" class="btn" style="font-family: 'Gotham bold'; background: #f8a924; color: white; border-radius: 20px;">Retornar</a>
                </div>
              `);
            }
          },
        });
      }
    });

    $("#my_barrel_state").on("change", function () {
      $.ajax({
        type: "POST",
        dataType: "JSON",
        url: cdc_user.ajax_url,
        data: {
          action: "list_cities_my_barrel_form",
          state: $("#my_barrel_state").val(),
        },
        success: function (response) {
          if (response.status) {
            $("#my_barrel_city").empty();
            $(response.cities).each(function (index, element) {
              $("#my_barrel_city").append(`
                <option value="${element.name}">${element.name}</option>
              `);
            });
          }
        },
      });
    });

    grecaptcha.ready(function () {
      grecaptcha
        .execute("6Lf1vDceAAAAACfQThQ_giVw6d0zuetRgNpcmhWQ", {
          action: "submit",
        })
        .then(function (token) {
          if (typeof token !== "undefined" && token !== null && token !== "") {
            let generate_token_element =
              document.getElementById("generate_token");
            if (generate_token_element) {
              generate_token_element.value = token;
            }
          }
        });
    });

    $("#clube_email_notification_form").validate({
      rules: {
        clube_email_notification_name: {
          required: true,
        },
        clube_email_notification_phone: {
          required: true,
          valid_phone: true,
        },
        clube_email_notification_email: {
          required: true,
          valid_email: true,
        },
      },
    });
    $("#clube_email_notification_phone").mask(SPMaskBehavior, spOptions);

    $(".cdc-clube-email-notification__submit").on("click", function (event) {
      event.preventDefault();
      if (
        $("#clube_email_notification_form").valid() &&
        PhoneIsValid &&
        EmailIsValid
      ) {
        $.ajax({
          type: "POST",
          dataType: "JSON",
          url: cdc_user.ajax_url,
          data: {
            action: "cdc_subscription_email_notification",
            name: $("#clube_email_notification_name").val(),
            phone: $("#clube_email_notification_phone").val(),
            email: $("#clube_email_notification_email").val(),
            woocommerce_nonce: $(
              "#woocommerce-cdc-email-subscription-notification-nonce",
            ).val(),
            token: $("#generate_token").val(),
          },
          success: function (response) {
            if (response.status) {
              $("#clube_email_notification_name").val(null);
              $("#clube_email_notification_phone").val(null);
              $("#clube_email_notification_email").val(null);

              $("#clube_modal").modal("show");
            }
          },
        });
      }
      return false;
    });

    if (
      $("body").hasClass("page-template-clube-pre-venda") ||
      $("body").hasClass("page-template-clube")
    ) {
      $(".cdc-clube-plans-nav__item").on("click", function () {
        var plan_id = $(this).attr("id");
        $(".carousel-item.active").removeClass("active");
        $(".cdc-clube-plans-products.active").removeClass("active");
        $(`[data-carousel-id="${plan_id}"]`).addClass("active");
        $(`[data-plans-products-id="${plan_id}"]`).addClass("active");
      });

      $(".carousel-button").on("click", function () {
        var carousel_active = $(".carousel-item.active").data("carousel-id");
        carousel_active = parseInt(carousel_active.replace(/\D/g, ""));

        $(`#plan_${carousel_active}`).removeClass("active");
        $(`[data-plans-products-id="plan_${carousel_active}"]`).removeClass(
          "active",
        );
        if ($(this).hasClass("carousel-control-next")) {
          if (carousel_active != 3) {
            $(`#plan_${carousel_active + 1}`).addClass("active");
            $(
              `[data-plans-products-id="plan_${carousel_active + 1}"]`,
            ).addClass("active");
          } else {
            $(`#plan_1`).addClass("active");
            $(`[data-plans-products-id="plan_1"]`).addClass("active");
          }
        }

        if ($(this).hasClass("carousel-control-prev")) {
          if (carousel_active != 1) {
            $(`#plan_${carousel_active - 1}`).addClass("active");
            $(
              `[data-plans-products-id="plan_${carousel_active - 1}"]`,
            ).addClass("active");
          } else {
            $(`#plan_3`).addClass("active");
            $(`[data-plans-products-id="plan_3"]`).addClass("active");
          }
        }
      });
    }
  });
})(jQuery);
