<!DOCTYPE html>
<html lang="en">



<?php include 'includes/header.php'?>

<body>
<div class="main-wrapper">

    <?php include 'includes/navbar.php'?>     

    <?php include 'includes/sidebar.php'?>

    <div class="page-wrapper">
            <div class="content">

Forms

<div class="row">
                    <div class="col-md-12">
                        <form action="#">
                            <div class="card-box">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="card-title">Personal details</h4>
                                        <div class="form-group">
                                            <label>Name:</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Password:</label>
                                            <input type="password" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>State:</label>
                                            <select class="select">
                                                <option>Select State</option>
                                                <option value="1">California</option>
                                                <option value="2">Texas</option>
                                                <option value="3">Florida</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Your message:</label>
                                            <textarea rows="5" cols="5" class="form-control" placeholder="Enter message"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="card-title">Personal details</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>First name:</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Last name:</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email:</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Phone:</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Address line:</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Country:</label>
                                                    <select class="select">
                                                        <option>Select Country</option>
                                                        <option value="1">USA</option>
                                                        <option value="2">France</option>
                                                        <option value="3">India</option>
                                                        <option value="4">Spain</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>State/Province:</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ZIP code:</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>City:</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <?php include 'includes/notifications.php' ?>
            </div>
    </div>

            <div class="sidebar-overlay" data-reff=""></div>
</div>

	
<?php include 'includes/scripts.php' ?>

</body>



</html>