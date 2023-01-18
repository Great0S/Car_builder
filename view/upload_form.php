
<h1>CSV Upload Form</h1>
<p>Choose an CSV file to upload.</p>

<form id="upload_form" action="/wp-content/plugins/car_builder/car_builder.php" enctype="multipart/form-data" method="post" target="messages">
    <p><input name="upload" id="upload" type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" /></p>
    <p><input id="btnSubmit" type="submit" value="Upload Selected Spreadsheet" /></p>
    <iframe name="messages" id="messages"></iframe>
    <p><input id="reset_upload_form" type="reset" value="Reset form" /></p>
</form>