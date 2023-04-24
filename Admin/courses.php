<?php

require '../connection.php';

if (isset($_GET['id'])) {
    $qry = $connection->query("SELECT * FROM courses where id= " . $_GET['id']);
    foreach ($qry->fetch_array() as $k => $val) {
        $$k = $val;
    }
}
?>

<?php
$course_query = "SELECT * FROM courses  order by course asc ";

$result = mysqli_query($connection, $course_query);
?>



<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Add Course and Fee</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
    <style>
        td {
            vertical-align: middle !important;
        }

        td p {
            margin: unset
        }

        img {
            max-width: 100px;
            max-height: :150px;
        }
    </style>

    <style>
        @media (min-width: 992px) {
            .modal-lg {
                max-width: 1300px;
            }
        }
    </style>
    <style>
        span button {
            float: right;
        }
    </style>
</head>

<body>



    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row mb-4 mt-4">
                <div class="col-md-12">
                </div>
            </div>
            <div class="row">
                <!-- FORM Panel -->

                <!-- Table Panel -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <b style="font-size:2rem;align-item:center;" class="display-1">List of Courses and Fees</b>
                            <span>
                                <button type="button" class="btn btn-primary btn-block btn-sm col-sm-2 py-2"
                                    style="background-color:#356155;color:white;" data-toggle="modal"
                                    data-target="#myModel"><b><i class="bi bi-plus-lg"></i></b> New
                                    Entry</button></span>

                        </div>
                        <div class="card-body">
                            <table class="table table-condensed table-bordered table-hover" id="display_courses">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="">Course/Duration</th>
                                        <th class="">Description</th>
                                        <th class="">Total Fee</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <tr>
                                                <td class="text-center">
                                                    <?php echo $i++ ?>
                                                </td>
                                                <td>
                                                    <p><b>
                                                            <?php echo $row['course'] . " - " . $row['level'] ?>
                                                        </b></p>
                                                </td>
                                                <td class="">
                                                    <p><small><i><b>
                                                                    <?php echo $row['description'] ?>
                                                                </b></i></small></p>
                                                </td>
                                                <td class="text-right">
                                                    <p><b>
                                                            <?php echo number_format($row['total_amount'], 2) ?>
                                                        </b></p>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-outline-primary edit_course"
                                                        type="button">Edit</button>
                                                    <button class="btn btn-sm btn-outline-danger delete_course" type="button"
                                                        onclick="confirmDelete('<?php echo $row['id'] ?>')">Delete</button>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Table Panel -->
            </div>
        </div>
    </div>


    <div class="modal" id="myModel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#356155;color:white;">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add New Courses and Fee Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form action="" id="manage-course">
                            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                            <div class="row">
                                <div class="col-lg-6 border-right">
                                    <h5><b>Course Details</b></h5>
                                    <hr>
                                    <div id="msg" class="form-group"></div>
                                    <div class="form-group">
                                        <label for="" class="control-label">Enter Course Name</label>
                                        <input type="text" class="form-control" name="course"
                                            value="<?php echo isset($course) ? $course : '' ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="control-label">Enter Duration of Course</label>
                                        <input type="text" class="form-control" name="level"
                                            value="<?php echo isset($level) ? $level : '' ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="control-label">Enter Course Description</label>
                                        <textarea name="description" id="" cols="30" rows="4" class="form-control"
                                            required=""><?php echo isset($description) ? $description : '' ?></textarea></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <h5><b>Fee Details</b></h5>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group mb-0">
                                            <label for="ft" class="control-label" style="margin-left:1rem;">Fee
                                                Type</label>
                                            <input type="text" id="ft" class="form-control-sm">
                                        </div>
                                        <div class="form-group mb-0">
                                            <label for="" class="control-label" style="margin-left:1rem;">Amount</label>
                                            <input type="number" step="any" min="0" id="amount"
                                                class="form-control-sm text-right">
                                        </div>
                                        <div class="form-group mb-0">
                                            <label for="" class="control-label">&nbsp;</label>
                                            <button class="btn btn-primary btn-sm" type="button" id="add_fee"
                                                style="background-color:#356155;color:white;">Add to
                                                List</button>
                                        </div>
                                    </div>
                                    <hr>
                                    <table class="table table-condensed" id="fee-list">
                                        <thead>
                                            <tr>
                                                <th width="5%"></th>
                                                <th width="50%">Type</th>
                                                <th width="45%">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($id)):
                                                $fees = $conn->query("SELECT * FROM fee_structure where course_id =" . $id);
                                                $total = 0;
                                                while ($row = $fees->fetch_assoc()):
                                                    $total += $row['amount'];
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><button class="btn-sm btn-outline-danger"
                                                                type="button" onclick="rem_list($(this))"><i
                                                                    class="bi bi-file-earmark-x-fill"></i></button></td>
                                                        <td>
                                                            <input type="hidden" name="fid[]" value="<?php echo $row['id'] ?>">
                                                            <input type="hidden" name="type[]"
                                                                value="<?php echo $row['description'] ?>">
                                                            <p><small><b class="ftype">
                                                                        <?php echo $row['description'] ?>
                                                                    </b></small></p>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="amount[]"
                                                                value="<?php echo $row['amount'] ?>">
                                                            <p class="text-right"><small><b class="famount">
                                                                        <?php echo number_format($row['amount']) ?>
                                                                    </b></small></p>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                endwhile;
                                            endif;
                                            ?>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2" class="text-center">Total</th>
                                                <th class="text-right">
                                                    <input type="hidden" name="total_amount"
                                                        value="<?php echo isset($total) ? $total : 0 ?>">
                                                    <span class="tamount">
                                                        <?php echo isset($total) ? number_format($total, 2) : '0.00' ?>
                                                    </span>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="fee_clone" style="display: none">
                        <table>
                            <tr>
                                <td class="text-center"><button class="btn-sm btn-outline-danger" type="button"
                                        onclick="rem_list($(this))"><i class="bi bi-trash"></i></button></td>
                                <td>
                                    <input type="hidden" name="fid[]">
                                    <input type="hidden" name="type[]">
                                    <p><small><b class="ftype"></b></small></p>
                                </td>
                                <td>
                                    <input type="hidden" name="amount[]">
                                    <p class="text-right"><small><b class="famount"></b></small></p>
                                </td>
                            </tr>
                        </table>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id='submit'
                        style="background-color:#356155;color:white;"
                        onclick="$('#myModel form').submit()">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>




    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#display_courses').DataTable({
                "pageLength": 5
            });
        });

        function confirmDelete(courseId) {
            alert(courseId);
            if (confirm("Are you sure you want to delete this course?")) {

                $.ajax({
                    url: 'ajax2.php?action=delete_course',
                    method: 'POST',
                    data: { subject_id: courseId },
                    success: function (data) {
                        alert('Course Delete successfully');
                        setTimeout(function () {
                            location.reload()
                        }, 1000)
                    }
                })

            }
        }
    </script>

    <script>
        $('#add_fee').click(function () {
            var ft = $('#ft').val();
            //alert(fee_type);
            var amount = $('#amount').val();
            if (amount == '' || ft == '') {
                alert("Please fill the Fee Type and Amount field first");
                return false;
            }
            var tr = $('#fee_clone tr').clone()
            var f = tr.find('[name="type[]"]').val(ft)
            var t = tr.find('.ftype').text(ft)
            var p = tr.find('[name="amount[]"]').val(amount)
            tr.find('.famount').text(parseFloat(amount).toLocaleString('en-US'))
            $('#fee-list tbody').append(tr)
            $('#ft').val('').focus()
            $('#amount').val('')
            calculate_total()
        })

        function calculate_total() {
            var total = 0;
            $('#fee-list tbody').find('[name="amount[]"]').each(function () {
                total += parseFloat($(this).val())
            })
            $('#fee-list tfoot').find('.tamount').text(parseFloat(total).toLocaleString('en-US'))
            $('#fee-list tfoot').find('[name="total_amount"]').val(total)

        }

        function rem_list(_this) {
            _this.closest('tr').remove()
            calculate_total()
        }

        $('#manage-course').submit(function (e) {
            e.preventDefault()
            $('#msg').html('')
            if ($('#fee-list tbody').find('[name="fid[]"]').length <= 0) {
                alert("Please insert at least 1 row in the fees table")
                end_load()
                return false;
            }
            $.ajax({
                url: 'ajax.php?action=save_course',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                success: function (resp) {
                    if (resp == 1) {
                        alert("Data successfully saved.");
                        setTimeout(function () {
                            location.reload()
                        }, 1000)
                    } else if (resp == 2) {
                        alert("Error in Ajax Request")
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('AJAX request failed: ' + textStatus + ' - ' + errorThrown);
                }
            });
        });

    </script>

</body>

</html>