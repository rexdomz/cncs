<!DOCTYPE html>
<html>
<head>
<title>Printing...</title>
</head>
<script src="{{ asset('js/print/jquery.min.js') }}"></script>
<script src="{{ asset('js/print/jquery.printPage.js') }}"></script>
<body>
<a href="{{URL::to('print-preview')}}" class="btnPrint">PrintMe</a>
<script type="text/javascript">
    $(document).ready(function () {
        $('.btnPrint').printPage();
    });
</script>
</body>
</html/>