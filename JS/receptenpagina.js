const zoekveld = document.querySelector(".zoeken");
const kaarten = document.querySelectorAll(".recepten");

zoekveld.addEventListener("input", function () {
    const zoekterm = zoekveld.value.toLowerCase();

    kaarten.forEach(function (kaart) {
        const titel = kaart.querySelector("h2").textContent.toLowerCase();

        if (titel.includes(zoekterm)) {
            kaart.style.display = "";
        } else {
            kaart.style.display = "none";
        }
    });
});