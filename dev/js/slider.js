// splide

if (document.getElementById("new-slider")) {
    var splide = new Splide("#new-slider", {
        type: "loop",
        perPage: 3,
        gap: "1rem",
        focus: "center",
        breakpoints: {
            1200: { perPage: 2, gap: "1rem" },
            640: { perPage: 1, gap: 0 },
        },
    });

    splide.mount();
}

if (document.getElementById("promotion-slider")) {
    var splide = new Splide("#promotion-slider", {
        type: "loop",
        perPage: 3,
        gap: "1rem",
        focus: "center",
        breakpoints: {
            1200: { perPage: 2, gap: "1rem" },
            640: { perPage: 1, gap: 0 },
        },
    });

    splide.mount();
}
