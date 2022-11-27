@extends('layout.app')
@section('content')
<div class="pagetitle">
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item">Category</li>
        <li class="breadcrumb-item active">Add</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
<section class="section">
    <div class="row">
      <div class="col-lg-6">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title"></h5>

            <!-- Horizontal Form -->
            <form>
              <div class="row mb-3">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Name:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputText" placeholder="Category" required>
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

