function openLinkButton(url) {
  window.open(url, "_self");
}
window.addEventListener("load", () => {
  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]'),
  );
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
  const columns = document.querySelectorAll(".product");
  columns.forEach((element, index) => {
    if (
      index >= 4 &&
      columns[
        index
      ].parentElement.parentElement.parentElement.parentElement.classList.contains(
        "product-a",
      )
    ) {
      element.classList.add("product-padding-top");
      element.classList.add("product-padding-bottom");
    }
  });

  document.addEventListener("click", (event) => {
    let button = event.target;
    if (
      button.classList.contains("hollow") ||
      button.classList.contains("click-area")
    ) {
      event.preventDefault();
      if (button.classList.contains("click-area"))
        button = button.parentElement;

      var valueCalc = 0;
      var quantity_max =
        button.parentElement.parentElement.children[1].getAttribute("max");
      switch (button.getAttribute("data-quantity")) {
        case "minus":
          valueCalc =
            parseInt(button.parentElement.parentElement.children[1].value) - 1;
          button.parentElement.parentElement.children[2].children[0].classList.remove(
            "disabled",
          );

          if (valueCalc <= 1) {
            valueCalc = 1;
            button.classList.add("disabled");
          }
          break;
        case "plus":
          valueCalc =
            parseInt(button.parentElement.parentElement.children[1].value) + 1;
          button.parentElement.parentElement.children[0].children[0].classList.remove(
            "disabled",
          );
          if (valueCalc >= quantity_max && quantity_max) {
            valueCalc = quantity_max;
            button.classList.add("disabled");
          }
          break;
      }

      button.parentElement.parentElement.parentElement.childNodes[3].setAttribute(
        "data-quantity",
        valueCalc,
      );
      window.localStorage.setItem("productQuantity", valueCalc);
      button.parentElement.parentElement.children[1].value = valueCalc;
    }
  });

  let reviewText = document.querySelector(".woocommerce-Reviews-title");
  if (reviewText) {
    reviewText.textContent = "AVALIAÇÃO";
  }

  if (document.querySelector(".woocommerce-shop")) {
    document
      .querySelector(".woocommerce-shop")
      .classList.add("woocomerce-home");
  }

  if (document.querySelector("#woosw_copy_btn")) {
    document.querySelector("#woosw_copy_btn").value = "Copiar";
  }

  if (document.body.classList.contains("blog")) {
    const modal = new bootstrap.Modal(document.getElementById("confirm-age"));
    const age = JSON.parse(localStorage.getItem("confirm-age"));
    if (!age) {
      modal.toggle();
      document.addEventListener("click", (event) => {
        const button = event.target;
        if (button.classList.contains("check-true")) {
          const check = document.querySelector("#check");
          if (check.checked) {
            localStorage.setItem("confirm-age", check.checked);
          }
          modal.toggle();
        }
      });
    }
  }
});

(function ($) {
  $(document).ready(function () {
    $("#my_barrel_prefer-supplier").select2({
      theme: "bootstrap-5",
    });
    $($("#my_barrel_prefer").select2("container")).addClass("form-select");
  });

  function timer_ajax() {
    $.ajax({
      url: cdc_user.ajax_url,
      type: "POST",
      dataType: "JSON",
      data: {
        action: "cart_timer",
      },
      success: function (response) {
        if (response.status) {
          if (window.cart_regressive_counter != null) {
            clearInterval(cart_regressive_counter);
          }
          var countDownDate = new Date(response.date).getTime();

          window.cart_regressive_counter = setInterval(function () {
            var now = new Date();
            now.setHours(now.getHours() + 3);
            now.getTime();

            var distance = countDownDate - now;

            var hours = Math.floor(
              (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60),
            );
            hours = hours < 10 ? "0" + hours : hours;
            var minutes = Math.floor(
              (distance % (1000 * 60 * 60)) / (1000 * 60),
            );
            minutes = minutes < 10 ? "0" + minutes : minutes;
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            seconds = seconds < 10 ? "0" + seconds : seconds;

            document.getElementById("cart-timer").innerHTML =
              hours + " | " + minutes + " | " + seconds;

            if (distance < 0) {
              clearInterval(cart_regressive_counter);
              document.getElementById("cart-timer").innerHTML =
                "00" + " | " + "00" + " | " + "00";
            }
          }, 1000);
        }
      },
    });
  }

  $(window).load(function () {
    if (
      document.body.classList.contains("woocommerce-cart") &&
      document.getElementsByClassName("cart-empty")[0] == null
    ) {
      timer_ajax();
    }
  });

  if (document.body.classList.contains("woocommerce-cart")) {
    document
      .querySelector(".woocommerce-cart .main-content")
      .addEventListener("click", function () {
        timer_ajax();
      });
  }

  function execute_ajax_shipping() {
    if (document.body.classList.contains("woocommerce-cart")) {
      var address = localStorage.getItem("address");
      address = JSON.parse(address);
      var checked_shipping_method = $(".shipping_method:checked")
        ? $(".shipping_method:checked").val()
        : "";

      $.ajax({
        url: cdc_user.ajax_url,
        type: "POST",
        dataType: "JSON",
        data: {
          action: "check_shipping",
          shipping_method: checked_shipping_method,
          city: address == null ? "" : address.localidade,
          postal_code: $("#calc_shipping_postcode").val(),
        },
        success: function (response) {
          if (response.status) {
            $(response.id_refrigerated).each(function (index, element) {
              $(".woocommerce-cart-form__cart-item[data-product_id]").each(
                function () {
                  if ($(this).data("product_id") == element) {
                    $(
                      `.woocommerce-cart-form__cart-item[data-product_id='${element}']`,
                    ).addClass("cart-refrigerated");
                  }
                },
              );
            });

            if (
              $(".woocommerce-cart-form__cart-item").length ==
              response.id_refrigerated.length
            ) {
              $(".checkout-button").prop("href", "javascript:void(0);");
              $(".checkout-button").css("cursor", "no-drop");
            } else {
              $(".checkout-button").prop("href", "/finalizar-compra");
              $(".checkout-button").css("cursor", "pointer");
            }

            if (!response.message) {
              $(".qib-button").attr("disabled", false);
              $(".wqpmb_input_text").attr("disabled", false);
              $(".woocommerce-cart-form__cart-item").removeClass(
                "cart-refrigerated",
              );
              $(".checkout-button").prop("href", "/finalizar-compra");
              $(".checkout-button").css("cursor", "pointer");
            } else {
              if ($("tbody tr").hasClass("cart-refrigerated")) {
                $(".cart-refrigerated .qib-button").prop("disabled", true);
                $(".cart-refrigerated .wqpmb_input_text").prop(
                  "disabled",
                  true,
                );
              }
            }
            $(".warning-refrigerate").empty();
            $(response.message).insertAfter(
              $(".woocommerce-cart-form__contents"),
            );
          }
        },
      });
    }
  }

  $(document).ready(function () {
    $(".view_month_selection").on("click", function () {
      $(this).toggleClass("closed");
      $(this).parent().children("#date_filter").slideToggle();
    });

    $(".date-filter").on("change", function (event) {
      var subscription_name;
      var selection_title_element;
      var selection_title;
      var thumbnail_name;

      var date = new Date($(this).val() + "-1");
      var options = { year: "numeric", month: "long" };
      var date_written = date.toLocaleDateString("pt-BR", options);
      date_written = event.target.value.length == 0 ? '' : `de ${date_written}`;
      switch ($(this).data("plan-id")) {
        case 6452:
          subscription_name = "#apreciadores";
          selection_title_element = "#apreciadores_title";
          selection_title = `Seleção Apreciadores ${date_written}`;
          thumbnail_name = "#apreciadores_thumbnail";
          break;
        case 6454:
          subscription_name = "#ipa";
          selection_title_element = "#ipa_title";
          selection_title = `Seleção 100% IPA ${date_written}`;
          thumbnail_name = "#ipa_thumbnail";
          break;
        case 6456:
          subscription_name = "#entusiastas";
          selection_title_element = "#entusiastas_title";
          selection_title = `Seleção Entusiastas ${date_written}`;
          thumbnail_name = "#entusiastas_thumbnail";
          break;
      }

      $.ajax({
        type: "POST",
        dataType: "JSON",
        url: cdc_subscription.ajax,
        data: {
          action: "cdc_store_get_subscription_products",
          subscription_id: $(this).data("plan-id"),
          date: $(this).val(),
        },
        success: function (response) {
          if (response.status) {
            $(subscription_name).empty();
            $(selection_title_element).empty();
            $(thumbnail_name).empty();
            $(selection_title_element).append(`
							<h3 class="cdc-clube-plans-products__title">${selection_title}</h3>
						`);

            if (response.thumbnail != "") {
              $(thumbnail_name).append(`
							<img src="${response.thumbnail}" alt="produto" class="img-fluid">
						`);
            }

            if (response.data) {
              response.data.map(function (element, index) {
                $(subscription_name).append(`
								<div class="cdc-clube-plans-products__item row mt-4">
									<div class="col-12 col-md-3 text-center">
										<img style="height:200px;" src="${element.product_image
                  }" alt="produto" class="img-fluid">
									</div>
									<div class="col-12 col-md-9 d-flex flex-column justify-content-center">
										<div class="cdc-clube-plans-products__item-country">
											<img src="${element.country_image}" alt="Pais" class="img-fluid">
										</div>
										<h1 class="cdc-clube-plans-products__item-title">${element.name}</h1>

										<div class="cdc-clube-plans-products__item-info">
											<div class="row">
												<div class="col-12 col-md-6">
													<b>Estilo: </b>
													<span>${element.style ? element.style : "--"}</span>
												</div>
												<div class="col-12 col-md-6">
													<b>Por Perfil: </b>
													<span>${element.profile}</span>
												</div>
												<div class="col-12 col-md-6">
													<b>Origem: </b>
													<span>${element.country ? element.country : "--"}</span>
												</div>
												<div class="col-12 col-md-6">
													<b>Estado: </b>
													<span>${element.state ? element.state : "--"}</span>
												</div>
												<div class="col-12 col-md-6">
													<b>Temperatura Ideal: </b>
													<span>${element.temperature_start
                    ? "Entre " +
                    element.temperature_start +
                    " E " +
                    element.temperature_end
                    : "--"
                  }</span>
												</div>
												<div class="col-12 col-md-6">
													<b>Embalagem: </b>
													<span>${element.package}</span>
												</div>
												<div class="col-12 col-md-6">
													<b>Volume: </b>
													<span>${element.volume ? element.volume : "--"}</span>
												</div>
												<div class="col-12 col-md-6">
													<b>Dosagem Alcoólica: </b>
													<span>${element.alcoholic_dosage ? element.alcoholic_dosage : "--"}</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							`);
              });
            }
          }
        },
      });
    });

    if (localStorage.getItem("address") == null) {
      if ($("#calc_shipping_postcode").val() != "") {
        execute_ajax_shipping();
        //check_value_for_free_shipping();
      }
      $(document.body).on("updated_cart_totals", function () {
        execute_ajax_shipping();
        //check_value_for_free_shipping();
      });
    } else {
      execute_ajax_shipping();
      //check_value_for_free_shipping();
      $(document.body).on("updated_cart_totals", function () {
        execute_ajax_shipping();
        //check_value_for_free_shipping();
      });
    }

    var modal_shipping = localStorage.getItem("shipping-free-marco");
    if (!modal_shipping) {
      $("#confirm-shipping").modal("show");
    }

    $(document).on("click", "#close_popup_shipping", function () {
      localStorage.setItem("shipping-free-marco", 1);
      $("#confirm-shipping").modal("hide");
    });
  });

  if (document.body.classList.contains("single-product")) {
    $(".woocommerce-product-gallery__image a").attr("target", "_blank");
  }

  if (
    $("body").hasClass("page-template-kits-and-souvenirs") ||
    $("body").hasClass("woocommerce-shop")
  ) {
    $(".product_type_bundle").addClass("ajax_add_to_cart");
  }

  $(".add_to_cart_button, .single_add_to_cart_button").on("click", function () {
    if ($(this).hasClass("product_type_subscription")) return;
    var cart = $(".cdc-icon--border");
    var imgtodrag = null;
    if ($("body").hasClass("single-product")) {
      var imgtodrag = $(".woocommerce-product-gallery figure div a img");
    } else {
      if($(this).hasClass('cdc-product__add_to_cart')){
        var imgtodrag = $(this).parent().parent().parent().children().children().first();
      }else{
        var imgtodrag = $(this).parent().children().children().first();
      }
    }

    read_more = $(this).text() == "Leia mais" ? true : false;
    if (imgtodrag && !read_more) {
      var imgclone = imgtodrag
        .clone()
        .offset({
          top: imgtodrag.offset().top,
          left: imgtodrag.offset().left,
        })
        .css({
          opacity: "0.5",
          position: "absolute",
          height: "150px",
          width: "150px",
          "z-index": "100",
        })
        .appendTo($("body"))
        .animate(
          {
            top: cart.offset().top + 10,
            left: cart.offset().left + 10,
            width: 75,
            height: 75,
          },
          1000,
        );

      imgclone.animate(
        {
          width: 0,
          height: 0,
        },
        function () {
          $(this).detach();
        },
      );
    }
  });

  async function request(filter) {
    try {
      const response = await $.post(`${cdc_user.ajax_url}`, {
        action: "search_products_by_name",
        filter: filter,
      });
      return response;
    } catch (error) {
      if (error.status != 200) {
        $(".cdc-search_products_by_name ul").empty();
        $(".cdc-search_products_by_name").show();
        $(".cdc-search_products_by_name ul").append(
          `<li class="not_remove_element product_not_found_in_search" data-bs-toggle="tooltip" data-bs-placement="top" title=""><a class="not_remove_element">Produto não Encontrado</a></li>`,
        );
        return error.status;
      }
    }
  }

  // Aviso de quando usuário acessa outro menu com a aplicação em andamento (00001272).
  async function execute_function(characteresPress) {
    const data = await request(characteresPress.value);
    // console.log(data)
    if (data == 404) return;
    $(".cdc-search_products_by_name ul").empty();
    $(".cdc-search_products_by_name").show();
    $(data.response).each((_index, element) => {
      let product_name =
        element.post_title.length >= 10
          ? element.post_title.substring(0, 20) + "..."
          : element.post_title;
      product_name = element.term_name ? product_name : element.post_title;

      const formatter = new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL",
      });

      let image = "";
      if (element.image) {
        let image_name = element.image.split(".");

        if (!image_name[0].includes("-scaled-")) {
          image_name[0] = image_name[0].replace("-scaled", "");
        }

        image_name[0] =
          image_name.length > 1
            ? image_name[0] + "-100x100"
            : image_name[0] + "-100x100.";
        image_name = image_name.join().replace(",", ".");
        image = `${window.location.origin}/wp-content/uploads/${image_name}`;
      } else {
        image = `${window.location.origin}/wp-content/uploads/woocommerce-placeholder-100x100.png`;
      }

      let ipi = element.ipi ? element.ipi.replace(/,/g, ".") : 0;
      let is_kit_full_price = element.kit_full_price
        ? parseFloat(element.kit_full_price) +
        parseFloat(element.kit_full_price * (ipi / 100))
        : parseFloat(element.regular_price) +
        parseFloat(element.regular_price * (ipi / 100));

      let sale_price_del_price = `<del class="not_remove_element">${formatter.format(
        is_kit_full_price,
      )}</del>`;

      let regular_price =
        parseFloat(element.regular_price) +
        parseFloat(element.regular_price * (ipi / 100));

      let sale_price =
        parseFloat(element.sale_price) +
        parseFloat(element.sale_price * (ipi / 100));

      let sale_price_or_kit_price = element.kit_full_price
        ? element.regular_price
        : sale_price;
      console.log(element)
      $(".cdc-search_products_by_name ul").append(`
                <li class="not_remove_element" data-bs-toggle="tooltip" data-bs-placement="top" title="${element.post_title
        }">
                <div class="row not_remove_element">
                  <div class="col-lg-8 col-sm-8 not_remove_element">
                    <a class="not_remove_element " href="/produto/${element.post_name
        }">
                        <div class="row not_remove_element">
                            <div class="col-3 col-md-2 not_remove_element search_products_image d-flex align-items-center">
                                <img class="not_remove_element search_image" src="${image}">
                            </div>
                            <div class="not_remove_element col-9 col-md-10">
                                <p class="not_remove_element ms-3 search_products_name line-clamp-3">${element.term_name
          ? product_name + " - "
          : product_name
        }</p>
                                <p class="not_remove_element ms-3 font_size-search_products"><span class="not_remove_element">${element.supplier_name
          ? element.supplier_name + " - "
          : ""
        }</span>${sale_price_or_kit_price
          ? sale_price_del_price
          : formatter.format(regular_price)
        } <span class="not_remove_element ms-2">${sale_price_or_kit_price
          ? formatter.format(sale_price_or_kit_price)
          : ""
        }</span></p>
                            </div>
                        </div>
                      
                    </a>
                  </div>
                  <div class="col-lg-3 col-sm-3 not_remove_element mt-2">
                    <button class="not_remove_element button product_type_simple add_to_cart_button ajax_add_to_cart add_button_searched" data-product_id="${element.ID}" data-product_sku="291">Adicionar ao carrinho</button>
                  </div>
                </div>
                    
                    
                </li>
            `);
    });
  }

  function check_value_for_free_shipping() {
    var checked_shipping_method = $(".shipping_method:checked")
      ? $(".shipping_method:checked").val()
      : "";
    $.ajax({
      url: cdc_user.ajax_url,
      type: "POST",
      dataType: "JSON",
      data: {
        action: "check_value_for_free_shipping",
        shipping_method: checked_shipping_method,
      },
      success: function (response) {
        $('.free-shipping-notice').remove();
        if (response.status) {
          $(".cart_totals .shop_table tbody > tr:nth-child(1)").after(`
              <tr class="free-shipping-notice">
                <td></td>
                <td style="color: red;">${response.message}</td>
              </tr>
            `)
        }
      }
    });
  }

  document.addEventListener("mouseover", (event) => {
    const e = event.target;
    if (
      e.classList.contains("cdc-search__form") ||
      e.classList.contains('search-box"') ||
      e.classList.contains("cdc-search_products_by_name") ||
      e.classList.contains("not_remove_element")
    )
      return;
    $(".cdc-search_products_by_name").hide();
  });

  var timer = null;
  document.addEventListener("keyup", async (event) => {
    const characteresPress = event.target;
    if (
      event.key == "Backspace" ||
      event.key == "Delete" ||
      characteresPress.value.length <= 0
    ) {
      $(".cdc-search_products_by_name").hide();
    }
    if (
      characteresPress.classList.contains("search_field") &&
      characteresPress.value.length >= 3
    ) {
      clearTimeout(timer);
      timer = setTimeout(() => {
        execute_function(characteresPress);
      }, 1000);
    }
  });

  $("#toggle_price_filter").on("click", function () {
    $toggle_filter_text =
      $("#toggle_price_filter").text() == "Exibir filtro por preço"
        ? "Esconder filtro por preço"
        : "Exibir filtro por preço";
    $("#toggle_price_filter").text($toggle_filter_text);
    $(".filter-by-price-wrapper").slideToggle();
  });

  if (document.body.classList.contains('woocommerce-checkout')) {
    $(document).on('click', '#place_order', function (event) {
      event.preventDefault();

      let subscription = $("#order_review td[data-is-subscription='1']");
      if (subscription && subscription.length > 0) {
        $(document).on('click', '#confirm_purchase', function () {
          let checkbox = $(document).find('#checkbox_confirm_subscription')
          let accept_conditions_label = $(document).find('#subscription_accept_conditions');
          if ($(checkbox).is(':checked')) {
            $(accept_conditions_label).removeClass('confirm-subscription-conditions-error');
            $('.btn-close').trigger('click');
            $('#checkout').trigger('submit');
          } else {
            $(accept_conditions_label).addClass('confirm-subscription-conditions-error');
          }
        });
      } else {
        $('#checkout').trigger('submit');
		$('#place_order').trigger('submit');
      }
    });
  }
	
  $(document.body).on('checkout_error', function (event, error_message) {

   
    $( document.body ).trigger( 'update_checkout');

  });  

  if ($('body').hasClass('woocommerce-edit-address') && $('#update_all_subscriptions_addresses').length > 0) {
    $('#update_all_subscriptions_addresses').prop('checked', true);
    $('#update_all_subscriptions_addresses').parent().css('pointer-events', 'none')
    $('#update_all_subscriptions_addresses').attr('style', 'color:gray;accent-color:gray;');
  }
})(jQuery);

if (document.querySelector(".cart-refrigerated")) {
  var disable_qty = document.querySelectorAll(
    ".cart-refrigerated .product-quantity .qib-button-wrapper",
  );
  disable_qty.forEach((element) => {
    element.childNodes[3].disabled = true;
    element.childNodes[9].disabled = true;
    element.childNodes[5].childNodes[1].disabled = true;
  });
}

var my_barrel = document.getElementById("my-barrel");
if (my_barrel) {
  const modal = new bootstrap.Modal(
    document.querySelector("#confirm-my_barrel"),
  );
  // controle de acesso a página para solicitar barril para que o usuário aceite as regras e caso acesse diretamente a url retorne para a home
  document.addEventListener("click", (event) => {
    const click = event.target;

    if (
      !document.querySelector("#checkbox_barrel").checked &&
      click.classList.contains("my_barrel_clicked")
    ) {
      const accept = document.querySelector("#barrel_accept_conditions");
      accept.classList.add("barrel_accept_conditions-error");
      return;
    }

    if (
      click.classList.contains("my_barrel_clicked") &&
      document.querySelector("#checkbox_barrel").checked
    ) {
      event.preventDefault();
      const minutes = 180;
      Cookies.set("barrel", "user_accept_barrel_rules", {
        expires: (1 / 1440) * minutes,
      });
      // const modal = new bootstrap.Modal(document.querySelector('#confirm-my_barrel'));
      modal.hide();
    }

    if (
      click.classList.contains("my_barrel_clicked") &&
      window.location.pathname != "/meu-barril/" &&
      document.querySelector("#checkbox_barrel").checked
    ) {
      window.location.href = "/meu-barril/";
      return;
    }
    return;
  });

  window.addEventListener("load", () => {
    if (
      Cookies.get("barrel") == undefined &&
      window.location.pathname == "/meu-barril/"
    ) {
      modal.show();
    }
  });
}
