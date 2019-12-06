<template>
  <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th v-for="(head, id) in headers" :key="id">{{head}}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(td, id) in data" :key="id">
                <td>{{department.department}}</td>
                <td>{{department.department_code}}</td>
                <td>
                    <button class="rounded-circle btn-danger" 
                    @click="delExamDepartment(department.id)">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        </tbody>                      
  </table>
</template>

<script>
export default {
    data() {
        return {

        }
    },
    props: {
        data: [],
        headers: []
    }

}
</script>

<style>

</style>