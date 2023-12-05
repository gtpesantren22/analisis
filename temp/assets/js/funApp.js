function calculateTotal(idTable, idAmount, idTotal) {
        var table = document.getElementById(idTable);
        var amounts = table.getElementsByClassName(idAmount);

        var total = 0;
        for (var i = 0; i < amounts.length; i++) {
            // Menghapus "Rp." dan mengonversi tanda titik ribuan
            var amountValue = amounts[i].textContent.replace('Rp. ', '').replace(/\./g, '').replace(',', '.');
            total += parseFloat(amountValue) || 0; // Menambahkan nilai 0 jika parsing gagal
        }

        // Tampilkan total dengan format Rupiah
        document.getElementById(idTotal).textContent = 'Rp. ' + accounting.formatMoney(total, "", 0, ".", ",");
    }