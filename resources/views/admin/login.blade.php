<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>Login Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('skote/assets/images/favicon.ico') }}">
    <link href="{{ asset('skote/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('skote/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('skote/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card overflow-hidden">
                    <div class="bg-primary-subtle">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-4">
                                    <h5 class="text-primary">Selamat Datang !</h5>
                                    <p>Login untuk melanjutkan ke panel admin.</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="{{ asset('skote/assets/images/profile-img.png') }}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="auth-logo">
                            <div class="avatar-md profile-user-wid mb-4">
                                <span class="avatar-title rounded-circle bg-light">
                                    <img src="{{ asset('skote/assets/images/logo.svg') }}" alt="" class="rounded-circle" height="34">
                                </span>
                            </div>
                        </div>
                        <div class="p-2">
                            @if($errors->any())
                                <div class="alert alert-danger">{{ $errors->first() }}</div>
                            @endif
                            <form method="POST" action="{{ route('admin.login.submit') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Masukkan email" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="input-group auth-pass-inputgroup">
                                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Captcha</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-light text-dark border px-3 py-2">{{ session('login_captcha_question') }}</span>
                                    </div>
                                    <input type="number" name="captcha_answer" class="form-control mt-2" placeholder="Masukkan hasil captcha" required>
                                </div>
                                <div class="mt-3 d-grid">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">Log In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mt-5 text-center">
                    <p>© {{ date('Y') }} PDAM. Crafted with Skote.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('skote/assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('skote/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('skote/assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('skote/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('skote/assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('skote/assets/js/app.js') }}"></script>
</body>
</html>