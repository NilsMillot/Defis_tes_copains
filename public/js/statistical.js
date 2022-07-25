$(document).ready(function () {

    /**
     * Partie Challenges
     */
    $.ajax({
        url: "/admin/statistical/data/challenge",
        type: "GET",
        success: function (data) {
            if (data) {
                let challengeDate = $("#challengeDate");
                let challengeDateGraph = new Chart(challengeDate, {
                    type: "line",
                    data: {
                        labels: data.challengeDate,
                        datasets: [
                            {
                                label: "Nombre de challenge par Date",
                                data: data.challengeCount,
                                backgroundColor:'rgba(0,0,0,0)',
                                borderColor:'#00acc1',
                                borderWidth:1,
                            },
                        ],
                    },
                    options:{
                        scales: {
                            y: {
                                title: {
                                    display: true,
                                },
                                min: 0,
                                max: 20,
                                ticks: {
                                    // forces step size to be 50 units
                                    stepSize: 5
                                }
                            }
                        },
                        legend:{
                            labels:{
                                fontColor:'#fff',
                            }
                        }
                    }
                });
            }
        },
    });

    /**
     * Partie Category
     */
    $.ajax({
        url: "/admin/statistical/data/category",
        type: "GET",
        success: function (data) {
            if (data) {
                let category = $("#categories");
                let categGraph = new Chart(category, {
                    type: "doughnut",
                    data: {
                        labels: data.categoryNom,
                        datasets: [
                            {
                                label: "Repartition des catégories",
                                data: data.categoryCount,
                                backgroundColor: [
                                    "#" +
                                    (
                                        "000000" +
                                        Math.floor(Math.random() * 16777215).toString(16)
                                    ).slice(-6),
                                    "#" +
                                    (
                                        "000000" +
                                        Math.floor(Math.random() * 16777215).toString(16)
                                    ).slice(-6),
                                    "#" +
                                    (
                                        "000000" +
                                        Math.floor(Math.random() * 16777215).toString(16)
                                    ).slice(-6),
                                ],
                            },
                        ],
                    },
                    options: {
                        responsive: false
                    }
                });
            }
        }
    });

    /**
     * Partie User
     */
    $.ajax({
        url: "/admin/statistical/data/user",
        type: "GET",
        success: function (data) {
            if (data) {
                let userDate = $("#userDate");
                let userDateGraph = new Chart(userDate, {
                    type: "line",
                    data: {
                        labels: data.userDate,
                        datasets: [
                            {
                                label: "Nombre de compte créer par jour",
                                data: data.userCount,
                                backgroundColor:'rgba(0,0,0,0)',
                                borderColor:'#00acc1',
                                borderWidth:1,
                            },
                        ],
                    },
                    options:{
                        scales: {
                            y: {
                                title: {
                                    display: true,
                                },
                                min: 0,
                                max: 20,
                                ticks: {
                                    // forces step size to be 50 units
                                    stepSize: 5
                                }
                            }
                        },
                        legend:{
                            labels:{
                                fontColor:'#fff',
                            }
                        }
                    }
                });
                let userPro = $('#userPro');
                let userProGraph = new Chart(userPro, {
                    type: "doughnut",
                    data: {
                        labels: ['Utilisateur Pro', 'Utilisateur'],
                        datasets: [
                            {
                                label: "Repartition des utilisateurs",
                                data: [data.userPro, data.userNonPro],
                                backgroundColor: [
                                    "#" +
                                    (
                                        "000000" +
                                        Math.floor(Math.random() * 16777215).toString(16)
                                    ).slice(-6),
                                    "#" +
                                    (
                                        "000000" +
                                        Math.floor(Math.random() * 16777215).toString(16)
                                    ).slice(-6),
                                    "#" +
                                    (
                                        "000000" +
                                        Math.floor(Math.random() * 16777215).toString(16)
                                    ).slice(-6),
                                ],
                            },
                        ],
                    },
                    options: {
                        responsive: false
                    }
                });
            }
        },
    });



});


