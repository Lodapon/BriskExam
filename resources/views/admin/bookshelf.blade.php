@extends('layouts.mainlayout')

@section('content')
    <!-- Wrapper Start -->
    <style>
        .aligncenter {
            text-align: center;
        }
    </style>
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Books List</h4>
                            </div>
                            <div class="iq-card-header-toolbar d-flex align-items-center">
                                <button type="button" class="btn btn-primary btn-block float-right mr-1" data-toggle="modal"
                                        data-target="#addBookModal"><i class="fa fa-plus-circle"></i> Add New Book
                                </button>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered mt-4 yajra-datatable" role="grid"
                                       aria-describedby="book-list-page-info">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Book's Name</th> <!-- Book Name -->
                                        <th>Problem No. (ข้อ)</th> <!-- Problem Number -->
                                        <th>Price (THB)</th>
                                        <th>Created by</th>
                                        <th>Created Date</th>
                                        <th>View Summarize</th> <!-- click to view popup card -->
                                        <th></th> <!-- button for delete this book -->
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Add Book -->
                            <div class="modal fade" id="addBookModal" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Fill Information for
                                                New Book</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <button type="button" class="btn btn-primary btn-block"
                                                    id="uploadCover_button"> + Book Cover Image
                                            </button>
                                            &nbsp;
                                            <input type="text" id="bookName" name="bookName" class="form-control"
                                                   placeholder="Book Name">
                                            &nbsp;
                                            <textarea id="bookDes" name="bookDes" class="form-control"
                                                      placeholder="Describtion" rows="5"></textarea>
                                            &nbsp;
                                            <input type="text" id="year" name="year" class="form-control"
                                                   placeholder="Year (if any)">
                                            &nbsp;
                                            <input type="number" id="probNum" name="probNum" class="form-control"
                                                   placeholder="Problem Number">
                                            &nbsp;
                                            <input type="number" id="price" name="price" class="form-control"
                                                   placeholder="Price">

                                            <input type="file" name="bookImg" class="custom-file-input" id="coverImg"
                                                   required="" accept="image/*" hidden/>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Cancel
                                            </button>
                                            <button type="button" class="btn btn-primary" id="addBook">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Show Book (Example) -->
                            <div class="modal fade" id="showBook" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Book Information</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="aligncenter">
                                                <img id="bookImagePreview" src="" class="float-center" width="400" height="400" />
                                            </p>
                                            &nbsp;
                                            <h4 id="bookNamePreview"></h4>
                                            &nbsp;
                                            <p id="bookDescPreview"></p>
                                            &nbsp;
                                            <p>จำนวนข้อ : <span id="bookTotalPreview"></span> ข้อ</p>
                                            &nbsp;
                                            <p>ราคา : <span id="bookPricePreview"></span> บาท</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Wrapper END -->
    <script type="text/javascript" src="{{ asset('/assets-custom/bookshelf.js') }}"></script>
@endsection
