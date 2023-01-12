import Chart from 'chart.js/auto';

  (async function() {
    tama = [
        {
          "id": 1,
          "name": "Null",
          "hungry": [70, 60, 55, 45, 40, 35, 30, 25, 15, 5, -5, 1, 0],
          "drink": [70, 55, 50, 80, 75, 70, 65, 60, 45, 75, 105, 90, 120],
          "boredom": [70, 55, 70, 65, 80, 95, 110, 125, 110, 105, 100, 85, 80],
          "sleep": [70, 100, 95, 90, 85, 80, 75, 70, 100, 95, 90, 120, 115]
        },
        {
          "id": 2,
          "name": "Koik",
          "hungry": [70],
          "drink": [70],
          "boredom": [70],
          "sleep": [70]
        },
        {
          "id": 3,
          "name": "Cran",
          "hungry": [70, 50, 100, 80, 75, 70, 70, 60, 90, 100, 95, 90, 85, 80, 75, 100, 90, 80, 75, 100, 90, 80, 100, 95, 85, 75, 100, 70, 65, 100, 90, 100, 90, 80, 70, 60],
          "drink": [70, 40, 20, 80, 75, 70, 70, 100, 90, 80, 75, 70, 65, 60, 55, 50, 35, 65, 60, 50, 35, 20, 10, 5, 35, 20, 10, 15, 50, 10, 40, 30, 60, 90, 100, 85],
          "boredom": [70, 40, 30, 20, 35, 50, 50, 45, 40, 35, 50, 65, 80, 95, 100, 90, 75, 70, 85, 80, 65, 50, 45, 60, 55, 40, 35, 55, 35, 35, 30, 25, 20, 15, 10, 0],
          "sleep": [70, 100, 90, 80, 75, 70, 70, 65, 60, 55, 50, 45, 40, 35, 30, 30, 60, 55, 50, 45, 75, 100, 95, 90, 85, 100, 95, 95, 95, 95, 90, 85, 80, 75, 70, 100]
        },
        {
          "id": 4,
          "name": "Kiwi",
          "hungry": [70],
          "drink": [70],
          "boredom": [70],
          "sleep": [70]
        }
      ];
    
  
    new Chart(
      document.getElementById('acquisitions'),
      {
        type: 'bar',
        data: {
          labels: data.map(row => tama[0].hungry),
          datasets: [
            {
              label: 'Acquisitions by year',
              data: data.map(row => tama[0].id)
            }
          ]
        }
      }
    );
  })();


(async function() {
  const data = [
    { year: 2010, count: 10 },
    { year: 2011, count: 20 },
    { year: 2012, count: 15 },
    { year: 2013, count: 25 },
    { year: 2014, count: 22 },
    { year: 2015, count: 30 },
    { year: 2016, count: 28 },
  ];

  new Chart(
    document.getElementById('acquisitions'),
    {
      type: 'line',
      data: {
        labels: data.map(row => row.year),
        datasets: [
          {
            label: 'Acquisitions by year',
            data: data.map(row => row.count)
          }
        ]
      }
    }
  );
})();