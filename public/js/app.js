$(document).ready(function () {
    $('#navbarDropdown').mouseenter(function (e) {
        e.preventDefault();
        $.ajax({
            url: "/panier/",
            method: "GET"
        }).done((articles) => {
            //console.log(prestation.panier);
            const contenuPanier = articles.panier;
            //console.log(panier);
            const imagePath = "/images/prestations/";
            $(".contenu-panier").empty();
            contenuPanier.forEach(function (article) {
                $(".contenu-panier").append(
                    `<tr id="ligne-${article.transfert.id}">
                         <td class="article-prestation-image">
                            <img src="${imagePath}/${article.transfert.imageName}" alt="${article.transfert.titre}" class="img-fluid">
                         </td>
                         <td class="article-prestation-titre-prix">
                            <span class="text-lg-center text-uppercase"><b>${article.transfert.titre}</b></span>
                            <br>
                            <span class="prix">${article.transfert.prix} €</span>
                         </td>
                         <td class="article-prestation-quantite">
                            <i id="augmenter-${article.transfert.id}" onclick="augmenter(${article.transfert.id})" class="fas fa-arrow-circle-up augmenter"></i>
                            <span id="quantite-${article.transfert.id}">${article.quantite}</span>
                            <i id="diminuer-${article.transfert.id}" onclick="diminuer(${article.transfert.id})" class="fas fa-arrow-circle-down diminuer"></i>
                         </td>
                         <td class="article-prestation-supprimer">
                            <i id="supprimer-${article.transfert.id}" onclick="supprimer(${article.transfert.id})" class="fas fa-trash"></i>
                         </td>
                    </tr>`
                );
            })

            if (contenuPanier.length) {
                $(`.contenu-panier`).append(
                    `<tr>
                    <td colspan="4">
                        <a href="/panier/checkout" class="btn btn-block btn-primary btn-valider-panier">valider le panier</a>
                    </td>
                </tr>`
                );
            }

        })
    }).click(function () {
        $('.contenu-panier').toggle();
    });
});

function augmenter(id) {
    $.ajax({
        url: `/panier/augmenter/${id}`,
        method: 'GET'
    }).done(function (data) {
        //console.log(data);
        $(`#quantite-${id}`).text(data.quantite);
    })
}

function diminuer(id) {
    $.ajax({
        url: `/panier/diminuer/${id}`,
        method: 'GET'
    }).done(function (data) {
        //console.log(data);
        let qte = data.quantite;
        if (qte > 0) {
            $(`#quantite-${id}`).text(data.quantite);
        } else {
            $(`#ligne-${id}`).fadeOut(1000);
        }
    })
}

function supprimer(id) {
    $.ajax({
        url: `/panier/supprimer/${id}`,
        method: 'GET'
    }).done(function (data) {
        if (data.resultat === 'OK') {
            // console.log(data.resultat);
            $(`#ligne-${id}`).fadeOut(1000);
        }
    })
}

