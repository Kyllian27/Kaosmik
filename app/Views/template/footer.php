</div>
</body>
<footer>
<?php if (isset($messages)) : ?>
    <script type="text/javascript">
        jQuery(function(){
            toastr.options = {
                "closeButton" : true,
                "progressBar": true,
                "onclick" : null,
                "showEasing" : "swing",
                "hideEasing" : "linear",
                "showMethod": "fadeIn",
                "hideMethod" : "fadeOut",
                "newestOnTop": true,
            };

            let messages = <?= json_encode($messages) ?>;
            let delay = 750;

            messages.forEach(function(elem, index) {
                setTimeout(function(){
                    toastr[elem.type](elem.txt);
                }, index * delay);
            })
        })
    </script>
<?php endif; ?>
</footer>
</html>