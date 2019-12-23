<template>
    <div class="card bg-gradient-primary border-left-success">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row d-flex justify-content-center">
                        <div class="form-group col-3">
                            <select
                                class="form-control form-control-sm"
                                @change="getExamScores"
                            >
                                <option value="" selected>Exams</option>
                                <option
                                    v-for="exam in exams"
                                    :key="exam.id"
                                    :value="exam.id"
                                >
                                    {{ exam.exam }}
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-3">
                            <select class="form-control form-control-sm">
                                <option value="" selected>Departments</option>
                                <option
                                    v-for="department in departments"
                                    :key="department.id"
                                    :value="department.id"
                                >
                                    {{ department.department }}
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-3">
                            <select class="form-control form-control-sm">
                                <option value="" selected>Courses</option>
                                <option
                                    v-for="course in courses"
                                    :key="course.id"
                                    :value="course.id"
                                >
                                    {{ course.course }}
                                </option>
                            </select>
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
            departments: [],
            courses: [],
            exams: [],
            examScores: []
        };
    },
    methods: {
        getFilterOptions() {
            axios
                .all([
                    axios.get("department"),
                    axios.get("course"),
                    axios.get("exam")
                ])
                .then(
                    axios.spread((departments, courses, exams) => {
                        this.departments = departments.data.data;
                        this.courses = courses.data.data;
                        this.exams = exams.data.data;
                    })
                );
        },
        getExamScores(e) {
            axios.get(`exam_scores/${e.target.value}`).then(res => {
                this.examScores = res.data;
            });
        }
    },
    created() {
        this.getFilterOptions();
    }
};
</script>

<style></style>
