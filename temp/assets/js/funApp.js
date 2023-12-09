// function calculateTotal(idTable, idAmount, idTotal) {
//         var table = document.getElementById(idTable);
//         var amounts = table.getElementsByClassName(idAmount);

//         var total = 0;
//         for (var i = 0; i < amounts.length; i++) {
//             // Menghapus "Rp." dan mengonversi tanda titik ribuan
//             var amountValue = amounts[i].textContent.replace('Rp. ', '').replace(/\./g, '').replace(',', '.');
//             total += parseFloat(amountValue) || 0; // Menambahkan nilai 0 jika parsing gagal
//         }

//         // Tampilkan total dengan format Rupiah
//         document.getElementById(idTotal).textContent = 'Rp. ' + accounting.formatMoney(total, "", 0, ".", ",");
//     }

function calculateTotal(idTable, idAmount, idTotal) {
    var table = document.getElementById(idTable);
    var amounts = table.getElementsByClassName(idAmount);

    var total = 0;
    for (var i = 0; i < amounts.length; i++) {
        // Menghapus "Rp." dan mengonversi tanda titik ribuan
        var amountValue = amounts[i].textContent.replace('Rp. ', '').replace(/\./g, '').replace(',', '.');
        total += parseFloat(amountValue) || 0; // Menambahkan nilai 0 jika parsing gagal
    }

    // Format total dengan format Rupiah tanpa menggunakan accounting.js
    var formattedTotal = formatMoney(total);
    
    // Tampilkan total dengan format Rupiah
    document.getElementById(idTotal).textContent = formattedTotal;
}

function calculateTotal2(idTable, idAmount, idTotal) {
    var table = document.getElementById(idTable);
    var amounts = table.getElementsByClassName(idAmount);

    var total = 0;
    for (var i = 0; i < amounts.length; i++) {
        // Menghapus "Rp." dan mengonversi tanda titik ribuan
        var amountValue = amounts[i].textContent.replace('Rp. ', '').replace(/\./g, '').replace(',', '.');
        total += parseFloat(amountValue) || 0; // Menambahkan nilai 0 jika parsing gagal
    }

    // Format total dengan format Rupiah tanpa menggunakan accounting.js
    // var formattedTotal = 'Rp. ' + formatMoney(total);
    
    // Tampilkan total dengan format Rupiah
    document.getElementById(idTotal).textContent = total;
}

// Fungsi untuk mengatur format Rupiah
function formatMoney(amount) {
    // Gunakan Intl.NumberFormat untuk format Rupiah
    var formatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0, // Menghilangkan nol di belakang koma
        maximumFractionDigits: 0
    });

    return formatter.format(amount);
}