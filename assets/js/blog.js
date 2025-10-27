

(function ($) {
    "use strict";

    class PostLoader {
        constructor(apiUrl) {
            this.apiUrl = apiUrl;
            this.page = 1;
            this.isLoading = false;
      		this.postList = document.getElementById("post-list");
      		this.loadingElement = document.getElementById("cdc-blog-loading");
            this.totalPages = 0;

            // Adiciona um evento de scroll para carregar mais posts
      		window.addEventListener("scroll", this.handleScroll.bind(this));
        }

        // Manipulador para o evento de scroll
        handleScroll() {
      	if (
       	 	window.innerHeight + window.scrollY >= document.body.offsetHeight &&
       	 	this.page <= this.totalPages
      		) {
                this.loadPosts();
            }
        }

        // Função para obter o valor do filtro da URL
        getFilterFromURL() {
            var searchParams = new URLSearchParams(window.location.search);
      		var filterValue = searchParams.get("columnist");
      		return filterValue || "";
        }

        // Função para obter o valor do ID do filtro ativo
        getIdColumnistByFilterURL() {
      		var item = document.querySelector(".cdc-blog-columns__item.active");
      		return item?.dataset.columnist || "";
        }

        // Carrega os posts da API do WordPress
        loadPosts() {
            if (this.isLoading) return;

            this.isLoading = true;
      		this.loadingElement.style.display = "flex";

            // Obtém o valor do filtro da URL
            var filter = this.getIdColumnistByFilterURL();

            // Faz uma requisição para a API do WordPress para obter os posts
            fetch(`${this.apiUrl}?page=${this.page}&columnist=${filter}`)
        		.then((response) => response.json())
        		.then((data) => {
                    if (!data.status) {
                        throw new Error(data.message);
                    }

                    // Renderiza cada post na página
          			data.data.forEach((post) => {
                        this.renderPost(post);
                    });

                    this.page++;
                    this.isLoading = false;
                    this.totalPages = data.total_pages;
          			this.loadingElement.style.display = "none";
        		})
        		.catch((error) => {
                    console.log(error);
                    this.isLoading = false;
          			this.loadingElement.style.display = "none";
                });
        }

        // Renderiza um post na página
        renderPost(post) {
      		const postItem = document.createElement("div");
      		postItem.className = "cdc-blog__item";

      		const image = document.createElement("img");
      		image.className = "cdc-blog__image";
      		image.setAttribute("loading", "lazy");
            image.src = post.image;
            postItem.appendChild(image);

      		const title = document.createElement("h2");
      		title.className = "cdc-blog__title";
      		title.setAttribute("title", post.title);
            title.textContent = post.title;
            postItem.appendChild(title);

      		const summary = document.createElement("div");
      		summary.className = "cdc-blog__summary";
            summary.innerHTML = post.excerpt;
            postItem.appendChild(summary);

      		const more = document.createElement("div");
      		more.className = "cdc-blog__more";
      		more.innerHTML = "<b>MAIS</b>";
            postItem.appendChild(more);

      		postItem.addEventListener("click", () => {
                this.redirectToPost(post.link);
            });

            this.postList.appendChild(postItem);
        }

        // Redireciona para a página completa do post
        redirectToPost(permalink) {
            window.location.href = permalink;
        }
    }

 	// Valida para que o JS sejá executado apenas na página do blog
  	if (!document.body.classList.contains("page-template-blog")) {
        return;
    }

    // Uso:
  	const apiUrl = "/wp-json/cdc-blog/v1/posts";
    const postLoader = new PostLoader(apiUrl);
  	postLoader.loadPosts();
})(jQuery);