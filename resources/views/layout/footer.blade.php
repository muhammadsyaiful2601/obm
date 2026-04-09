 <footer class="main-footer">
     <div class="footer-left">
         Copyright &copy; <span id="years"></span>
         <div class="bullet"></div> Muhammad Syaiful D3 Sistem Informasi
     </div>
 </footer>

 </div>
 </div>

 <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
 <script src="{{ asset('assets/modules/popper.js') }}"></script>
 <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
 <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
 <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
 <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
 <script src="{{ asset('assets/js/stisla.js') }}"></script>

 <script src="{{ asset('assets/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
 <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
 <script src="{{ asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

 <script src="{{ asset('assets/js/scripts.js') }}"></script>
 <script src="{{ asset('assets/js/custom.js') }}"></script>
 <script>
     // otomatis update tahun di footer
     document.getElementById('years').textContent = new Date().getFullYear();
 </script>
