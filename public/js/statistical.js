$(document).ready(function () {
  $.ajax({
    url: "/admin/statistical/data",
    type: "GET",
    success: function (data) {
      console.log(data);
      if (data) {
        let category = $("#categories");

        let categGraph = new Chart(category, {
          type: "pie",
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
        });
        let challengeDate = $("#challengeDate");
        let challengeDateGraph = new Chart(challengeDate, {
          type: "line",
          data: {
            labels: data.challengeDate,
            datasets: [
              {
                label: "Nombre de challenge par Date",
                data: data.challengeCount,
              },
            ],
          },
          options: {
            scales: {
              xAxes: [
                {
                  type: "time",
                  time: {
                    displayFormats: {
                      quarter: "MMM YYYY",
                    },
                  },
                },
              ],
            },
          },
        });
      }
    },
  });
});
