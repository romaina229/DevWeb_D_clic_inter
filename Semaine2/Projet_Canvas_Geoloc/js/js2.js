const canvas = document.getElementById('myCanvas');
    const ctx = canvas.getContext('2d');
    const data = [];

    function drawGraph() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);

      ctx.fillStyle = '#2e86de';
      const barWidth = 40;
      const gap = 20;

      for (let i = 0; i < data.length; i++) {
        const x = i * (barWidth + gap) + 30;
        const y = canvas.height - data[i];
        ctx.fillRect(x, y, barWidth, data[i]);
        ctx.fillStyle = '#000';
        ctx.fillText(data[i], x + 10, y - 5);
        ctx.fillStyle = '#2e86de';
      }
    }

    function addData() {
      const input = document.getElementById('valueInput');
      const value = parseInt(input.value);
      if (!isNaN(value) && value > 0) {
        data.push(value);
        drawGraph();
        input.value = '';
      } else {
        alert("Veuillez entrer un nombre positif !");
      }
    }