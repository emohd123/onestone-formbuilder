@php
    $hashids = new Hashids('', 20);
    $id = $hashids->encodeHex($form->id);
@endphp
<div class="row">
    <div class="text-center" id="qrCodeContainer">
        {!! QrCode::size(200)->generate(route('forms.survey', $id)) !!}
    </div>
</div>
<div class="row">
    <button type="button" id="downloadBtn" class="btn btn-dark mt-4 btn-sm">Download</button>
</div>

<script>
    document.getElementById('downloadBtn').addEventListener('click', function() {
        var qrCodeContainer = document.getElementById('qrCodeContainer');

        // Use html2canvas to render the content of qrCodeContainer
        html2canvas(qrCodeContainer).then(function(canvas) {
            // Convert the canvas to a data URL
            var dataUrl = canvas.toDataURL('image/png');

            // Create a download link for the PNG file
            var downloadLink = document.createElement('a');
            downloadLink.href = dataUrl;
            downloadLink.download = 'qr_code.png';

            // Trigger the download
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        });
    });
</script>
