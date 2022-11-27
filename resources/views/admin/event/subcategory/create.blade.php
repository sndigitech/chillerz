@extends('layout.app')
@section('content')
<div class="pagetitle">
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item">SubCategory</li>
        <li class="breadcrumb-item active">Add</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
<section class="section">
    <div class="row">
      <div class="col-lg-9">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title"></h5>

            <!-- Horizontal Form -->
            <form>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Category</label>
                    <div class="col-sm-8">
                      <select class="form-select" aria-label="Default select example">
                        <option selected>-- please select --</option>
                        <option value="1">Bar & Nightclubs</option>
                        <option value="2">Shows & Music</option>
                        <option value="3">Cinema & Theaters</option>
                        <option value="4">Shows & Music</option>
                        <option value="5">Sport</option>
                      </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">SubCategory Name:</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" name="subcat" id="inputText" placeholder="Category" required>
                    </div>
                </div>

              <div class="text-center">
                <button type="submit" class="btn btn-primary">Add</button>
              </div>
            </form><!-- End Horizontal Form -->

          </div>
        </div>
      </div>
    </div>
    </div>
  </section>
  @endsection

