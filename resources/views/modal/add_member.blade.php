{{-- <div class="modal" id="add_project_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add Project</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<<<<<<< Updated upstream
data-toggle="modal" data-target="#exampleModalLong" --}}
=======
 data-toggle="modal" data-target="#exampleModalLong" --}}
<style>
    .autocomplete {
        position: relative;
    }
>>>>>>> Stashed changes

    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        /*position the autocomplete items to be the same width as the container:*/
        top: 100%;
        left: 0;
        right: 0;
    }

<<<<<<< Updated upstream
=======
    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #d4d4d4;
    }

    .autocomplete-items div:hover {
        /*when hovering an item:*/
        background-color: #e9e9e9;
    }

    .autocomplete-active {
        /*when navigating through the items using the arrow keys:*/
        background-color: DodgerBlue !important;
        color: #ffffff;
    }

</style>


>>>>>>> Stashed changes
<!-- User Modal -->
<div class="modal fade" id="add_member_modal" tabindex="-1" role="dialog" aria-labelledby="add-modal-label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md vw-50" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-member-modal-label">Add Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0 pb-0" id="attachment-body-content">
                {{-- <form id="user-form" class="form-horizontal" method="POST" action=""> --}}
                @csrf
                <div class="card mb-0">
                    {{-- <div class="card-header">
<<<<<<< Updated upstream
                            <h2 class="m-0">Edit</h2>
                        </div> --}}
                    <div class="card-body">
                        <div class="form-group">
                            <label class="col-form-label" for="modal-input-member-project-id">Project Id</label>
                            <input type="text" name="project_member_id" class="form-control" id="modal-input-member-project-id" required>
                        </div>
                        <!-- id -->
                        <div class="form-group">
                            <label class="col-form-label" for="modal-input-username">Username</label>
                            <input type="text" name="member_project_id" class="form-control" id="modal-input-project-member-username" required>
=======
                             <h2 class="m-0">Edit</h2>
                         </div> --}}
                    <div class="card-body">
                        {{-- <div class="form-group">
                             <label class="col-form-label" for="modal-input-member-project-id">Project id</label>
                             <input type="text" name="project_member_id" class="form-control" id="modal-input-member-project-id" required>
                         </div> --}}
                        <!-- id -->
                        <div class="form-group autocomplete">
                            <label class="col-form-label" for="modal-input-project-member-username">Username</label>
                            <input type="text" name="member_id" class="form-control" autocomplete="off"
                                id="modal-input-project-member-username" required>
>>>>>>> Stashed changes
                        </div>
                        <!-- /id -->
                        <!-- name -->
                        {{-- <div class="form-group">
<<<<<<< Updated upstream
                                <label class="col-form-label" for="modal-input-name">นามสกุล</label>
                                <input type="text" name="lname" class="form-control" id="modal-input-lastName" required>
                            </div> --}}
                        <!-- /name -->
                        <!-- description -->
                        {{-- <div class="form-group">
                                <label class="col-form-label" for="modal-input-description">เบอร์โทรศัพท์</label>
                                <input type="text" name="phone" class="form-control" id="modal-input-phone" required>
                            </div> --}}
                        {{-- department --}}
                        {{-- <div class="form-group">
                                <label class="col-form-label" for="modal-input-description">สังกัด</label>
                                <input type="text" name="department" class="form-control" id="modal-input-department" required>
                            </div> --}}
                        {{-- <div class="form-group">
                                <label class="col-form-label" for="modal-input-description">ประเภท</label>
                                {{-- <input type="text" name="permission" class="form-control" id="modal-input-permission"
                                    required> --}}
                        {{-- <select class="form-control" id="modal-input-permission" required>
                                        <option value="1">Admin (ผู้ดูแลระบบ)</option>
                                        <option value="2">Board (ผู้บริหาร)</option>
                                        <option value="3">User (บุคลากรต่างๆ ของคลัง)</option>
                                    </select>
                            </div> --}}
=======
                                 <label class="col-form-label" for="modal-input-name">นามสกุล</label>
                                 <input type="text" name="lname" class="form-control" id="modal-input-lastName" required>
                             </div> --}}
                        <!-- /name -->
                        <!-- description -->
                        {{-- <div class="form-group">
                                 <label class="col-form-label" for="modal-input-description">เบอร์โทรศัพท์</label>
                                 <input type="text" name="phone" class="form-control" id="modal-input-phone" required>
                             </div> --}}
                        {{-- department --}}
                        {{-- <div class="form-group">
                                 <label class="col-form-label" for="modal-input-description">สังกัด</label>
                                 <input type="text" name="department" class="form-control" id="modal-input-department" required>
                             </div> --}}
                        {{-- <div class="form-group">
                                 <label class="col-form-label" for="modal-input-description">ประเภท</label>
                                 {{-- <input type="text" name="permission" class="form-control" id="modal-input-permission"
                                     required> --}}
                        {{-- <select class="form-control" id="modal-input-permission" required>
                                         <option value="1">Admin (ผู้ดูแลระบบ)</option>
                                         <option value="2">Board (ผู้บริหาร)</option>
                                         <option value="3">User (บุคลากรต่างๆ ของคลัง)</option>
                                     </select>
                             </div> --}}
>>>>>>> Stashed changes
                    </div>
                </div>
                {{-- </form> --}}
            </div>
            <div class="modal-footer">
<<<<<<< Updated upstream
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button id="add_member" type="submit" class="btn btn-primary">Save</button>
=======
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button id="add_member" type="submit" class="btn btn-success">Save</button>
>>>>>>> Stashed changes
            </div>
        </div>
    </div>
</div>
<!-- /User Modal -->
<<<<<<< Updated upstream
<script>
=======
<script type="text/javascript">
    $('#modal-input-project-member-username').keyup(function(e) {
        const token = $.cookie('token');
        const username = $.cookie('username');
        const searchText = $(this).val();

        if (searchText == '') {
            return
        }

        $.ajax({
            type: "GET",
            url: "/api/project/member/get/" + searchText,
            headers: {
                'Authorization': 'Bearer ' + token,
            },
            success: function(response) {
                if (response.status == 200) {
                    let array = [];
                    response.data.forEach(item => {
                        if (username != item.username) {
                            array.push(item.username)
                        }
                    });
                    autocomplete(document.getElementById(
                        "modal-input-project-member-username"), array);
                }
            }
        });
    });

    $('#add_member').click(function(e) {
        e.preventDefault();
        const token = $.cookie('token');
        const projectId = $('#btn_add_member').data('id');
        const username = $('#modal-input-project-member-username').val();

        const formData = {
            projectId: projectId,
            username: username
        }
        console.log(formData)
        $.ajax({
            type: "POST",
            url: "/api/project/member/add",
            data: formData,
            headers: {
                'Authorization': 'Bearer ' + token,
            },
            success: function(response) {
                if (response.status == 200) {
                    window.location.reload();
                }
            }
        });

        $('#add_member_modal').modal('hide');

    });

    function autocomplete(inp, arr) {
        /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
        var currentFocus;
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value;
            /*close any already open lists of autocompleted values*/
            closeAllLists();
            if (!val) {
                return false;
            }
            currentFocus = -1;
            /*create a DIV element that will contain the items (values):*/
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            /*append the DIV element as a child of the autocomplete container:*/
            this.parentNode.appendChild(a);
            /*for each item in the array...*/
            for (i = 0; i < arr.length; i++) {
                /*check if the item starts with the same letters as the text field value:*/
                if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    /*create a DIV element for each matching element:*/
                    b = document.createElement("DIV");
                    /*make the matching letters bold:*/
                    b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                    b.innerHTML += arr[i].substr(val.length);
                    /*insert a input field that will hold the current array item's value:*/
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                    /*execute a function when someone clicks on the item value (DIV element):*/
                    b.addEventListener("click", function(e) {
                        /*insert the value for the autocomplete text field:*/
                        inp.value = this.getElementsByTagName("input")[0].value;
                        /*close the list of autocompleted values,
                        (or any other open lists of autocompleted values:*/
                        closeAllLists();
                    });
                    a.appendChild(b);
                }
            }
        });
        /*execute a function presses a key on the keyboard:*/
        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                /*If the arrow DOWN key is pressed,
                increase the currentFocus variable:*/
                currentFocus++;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 38) { //up
                /*If the arrow UP key is pressed,
                decrease the currentFocus variable:*/
                currentFocus--;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 13) {
                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                e.preventDefault();
                if (currentFocus > -1) {
                    /*and simulate a click on the "active" item:*/
                    if (x) x[currentFocus].click();
                }
            }
        });
>>>>>>> Stashed changes

        function addActive(x) {
            /*a function to classify an item as "active":*/
            if (!x) return false;
            /*start by removing the "active" class on all items:*/
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            /*add class "autocomplete-active":*/
            x[currentFocus].classList.add("autocomplete-active");
        }

        function removeActive(x) {
            /*a function to remove the "active" class from all autocomplete items:*/
            for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
            }
        }

        function closeAllLists(elmnt) {
            /*close all autocomplete lists in the document,
            except the one passed as an argument:*/
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }
        /*execute a function when someone clicks in the document:*/
        document.addEventListener("click", function(e) {
            closeAllLists(e.target);
        });
    }
    // autocomplete(document.getElementById("myInput"), countries);

</script>
