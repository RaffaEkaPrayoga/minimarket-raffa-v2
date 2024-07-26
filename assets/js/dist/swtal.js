$(".tombol-hapus").on("click", function (e) {
  $link = $(this).attr("href");
  e.preventDefault();
  Swal.fire({
    title: "Yakin Ingin Menghapus Data Ini?",
    text: "Data Akan Dihapus!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "green",
    cancelButtonColor: "red",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = $link;
    }
  });
});
