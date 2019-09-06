<template>
    <div class="card text-white bg-gradient-primary border-left-warning">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title">Settings</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <h4>Username: {{currentUser.username}}</h4>
                            <h4>
                                <button type="button" class="btn btn-primary btn-sm">Change Username/Password</button>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {

            }
        },
        props: {
            currentUser: ''
        }
    }
</script>

