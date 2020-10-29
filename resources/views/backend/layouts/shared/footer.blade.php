
<footer class="footer mt-auto">
    <div class="copyright bg-white">
        <p>
            &copy; <span id="copy-year">2019</span> Copyright Sleek Dashboard Bootstrap Template by
            <a
                class="text-primary"
                href="http://www.iamabdus.com/"
                target="_blank"
            >Abdus</a
            >.
        </p>
    </div>
    <script>
        var d = new Date();
        var year = d.getFullYear();
        document.getElementById("copy-year").innerHTML = year;
    </script>
</footer>

</div>
</div>

<script src="{{backendAssets('plugins/jquery/jquery.min.js')}}"></script>
<script src="{{backendAssets('plugins/slimscrollbar/jquery.slimscroll.min.js')}}"></script>
<script src="{{backendAssets('js/sleek.bundle.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>



        function RemoveItem(formId){
            Swal.fire({
                title: `<h3>Do you want to remove the this?</h3>`,
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonColor: '#dd6b55',
                confirmButtonText: `Save`,
                denyButtonText: `Don't save`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $('#'+formId).submit();
                }
            })
        }

</script>
@yield('js')

<script>
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
          $('#img-preview').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]); // convert to base64 string
      }
    }
    
    $("#coverImage").change(function() {
      readURL(this);
    });    
    </script>
</body>

</html>
