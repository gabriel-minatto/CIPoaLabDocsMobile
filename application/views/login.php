<div class="card-header">
    <div class="row align-items-center">
        <div class="col-xl-10">
            <h2>Login</h2>
        </div>
    </div>
</div>
<div class="card-body">

    <?php if($this->session->flashdata('success')) { ?>
        <div class="container">
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?= $this->session->flashdata('success'); ?>
            </div>
        </div>
    <?php } else if($this->session->flashdata('errors')) {
        foreach($this->session->flashdata('errors') as $err) { ?>
            <div class="container">
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= $err; ?>
                </div>
            </div>
    <?php }} ?>

    <form class="form-horizontal" method="POST" action="<?= base_url().'index.php/media/login' ?>">

        <fieldset>

            <!-- Email input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="name">Email</label>
                <div class="col-xl-12">
                    <input id="email" name="email" type="email" placeholder="email" class="form-control input-md" required="">
                </div>
            </div>

            <!-- Password input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="name">Senha</label>
                <div class="col-xl-12">
                    <input id="password" name="password" type="password" placeholder="senha" class="form-control input-md" required="">
                </div>
            </div>

            <!-- Button -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="submit"></label>
                <div class="col-xl-12">
                    <button id="submit" name="submit" class="btn btn-success">Entrar</button>
                </div>
            </div>

        </fieldset>

    </form>
</div>