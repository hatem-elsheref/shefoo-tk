
<footer class="footer mt-auto">
    <div class="copyright bg-white">
        <p>
            &copy; <span id="copy-year">2019</span> Copyright Sleek Dashboard Bootstrap Template by
            <a
                class="text-primary"
                href="https://www.linkedin.com/in/hatem-mohamed-31b8901a2/"
                target="_blank"
            >Hatem Mohamed</a
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
<script src="{{backendAssets('plugins/select2/js/select2.min.js')}}"></script>
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
    // show the uploaded image as a live preview
    function readURL(input) {
      if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
          $('#img-preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
      }
    }
    $("#coverImage").change(function() {
      readURL(this);
    });


    // manage the system direction (rtl-ltr)
    $(document).ready(function () {
    let ltr = jQuery('.ltr-to');
    let rtl = jQuery('.rtl-to');

    @if(LaravelLocalization::getCurrentLocaleDirection() === 'ltr')
        activeTheNeededDirection(ltr,rtl,'ltr')
    @else
        activeTheNeededDirection(rtl,ltr,'rtl')
    @endif
    });
    function activeTheNeededDirection(newObject,oldObject,direction){
        jQuery(newObject).addClass('btn-right-sidebar-2-active');
        oldObject.removeClass('btn-right-sidebar-2-active');
        $('html').attr('dir', direction);
        if (direction === 'ltr')
            $("#sleek-css").attr("href", "{{backendAssets('css/sleek.css')}}");
        else
            $("#sleek-css").attr("href", "{{backendAssets('css/sleek.rtl.css')}}");
        window.dir = direction;

        //Store in local storage
        // setOptions("direction", direction);
        let optionsCopy={
            "direction":direction
        }
        localStorage.setItem("optionsObject", JSON.stringify(optionsCopy));

    }

    </script>

@yield('js')
</body>
</html>
