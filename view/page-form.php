<!-- wp:template-part {"slug":"header"} /-->
<form method="post" action="<?php current_page(); ?>">
    <div class="mb-3">
        <input type="checkbox" class="btn-check" id="btn-check" autocomplete="off">
        <label class="btn btn-primary" for="btn-check">Single toggle</label>
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1">
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<!-- <form class="brands tab form" id="brand" >
        <h3 class="h3 mb-3 fw-normal">Please choose a car brand</h3>
        <div class="list-group list-group-checkable border-0 flex-sm-row" id="brands-selector">

        </div>

        <button onchange="" class="btn btn-primary" onclick="open_tab(event, 'model'), get_data($array, $criteria, 2, 1);">Choose</button>

    </form>

    Getting car models -->
<!-- <form class="models tab" id="model">
        <h3 class="tab-title">Car models</h3>
        <div class="list-group list-group-checkable d-grid border-0 flex-sm-row" id="models-selector">

        </div> -->
<!-- </form> -->