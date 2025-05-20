document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('real-estate-filter');
    const cardsContainer = document.getElementById('real-estate-cards');
    const loadMoreWrapper = document.getElementById('load-more-wrapper');
    const loadMoreButton = document.getElementById('load-more');

    let currentPage = 1;

    function fetchResults(reset = false) {
        const data = new FormData(form);
        data.append('paged', currentPage);
        const params = new URLSearchParams(data).toString();

        fetch(real_estate_ajax.ajaxurl + '?action=real_estate_filter&' + params)
            .then(response => response.text())
            .then(html => {
                if (reset) {
                    cardsContainer.innerHTML = html;
                } else {
                    cardsContainer.insertAdjacentHTML('beforeend', html);
                }

                if (cardsContainer.querySelector('#end-of-results') || html.includes('No results found')) {
                    loadMoreWrapper.style.display = 'none';
                } else {
                    loadMoreWrapper.style.display = 'block';
                }                
            })
            .catch(err => {
                cardsContainer.innerHTML = '<p>Error loading results</p>';
                console.error(err);
            });
    }

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            currentPage = 1;
            fetchResults(true);
        });
    }

    if (loadMoreButton) {
        loadMoreButton.addEventListener('click', function () {
            currentPage++;
            fetchResults(false);
        });
    }

    fetchResults(true);
});