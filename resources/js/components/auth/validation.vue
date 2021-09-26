<template>
    <div>
        <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Contact System Administrator for Verification.</h1>
                  </div>
                 
                  <hr>
                  <div class="text-center">
                    <router-link to="/login" class="font-weight-bold small">Login</router-link>
                  </div>
                 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
</template>

<script type="text/javascript">

export default {

    created(){
    if (User.loggedIn()) {
      this.$router.push({ name: 'home' })
    }
  },

  }
 

</script>

<style type="text/css">
</style>