<template>
  <div class="px-sm-1 px-md-5 pt-1">
    <div class="col-md-6 col-sm-12 ml-auto mr-auto">
      <img :src="`./storage/images/LibLog.png`" style="width: 100%;" />
    </div>
    <nav class="navbar navbar-expand-sm shadow-sm navbar-dark bg-gradient-primary">
      <button
        class="navbar-toggler d-lg-none"
        type="button"
        data-toggle="collapse"
        data-target="#collapsibleNavId"
        aria-controls="collapsibleNavId"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="#">
              Resource
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Rules & Regulations</a>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <div class="input-group">
            <input
              v-model="searchText"
              type="text"
              class="form-control form-control-sm"
              name="name"
              id="name"
              placeholder
              aria-label
            />
            <span class="input-group-btn">
              <button @click="searchByText" class="btn btn-danger btn-sm" type="button" aria-label>
                <i class="fas fa-search"></i>
              </button>
            </span>
          </div>
        </form>
      </div>
    </nav>
    <div class="jumbotron shadow-sm py-2 pl-0 mb-0">
      <div class="row">
        <div class="col-md-2 col-sm-6 p-0 mt-sm-1 mt-md-3">
          <div class="list-group">
            <button
              class="list-group-item list-group-item-action btn-sm p-1 shadow-sm"
              v-for="type in res_types"
              :key="type.id"
              @click.prevent="gotoType(type.id)"
            >{{type.res_type}}</button>
          </div>
        </div>
        <div class="col-md-10 col-sm-12" v-for="type in res_types" :key="type.id">
          <div class="row d-flex justify-content-center">
            <div v-for="book in books" :key="book.id" @click="res_read(book)">
              <div class="card read" v-if="book.res_type_id == type.id">
                <img
                  class="img-rounded img-thumbnail"
                  :src="path+book.res_type.res_type+cover+book.res_cover"
                />
                <div class="top-left px-2 text-center text-white">
                  <h5>{{book.res_title}}</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 mb-2 p-0 mt-2 d-flex justify-content-between">
      <nav aria-label="Page navigation">
        <ul class="pagination mx-auto">
          <li class="page-item" v-if="res_meta.prev_page_url">
            <button class="btn-sm page-link" @click.prevent="gotoPrev" aria-label="Previous">
              <i class="fas fa-arrow-circle-left"></i>
              <span class>Prev page</span>
            </button>
          </li>

          <li class="page-item" v-if="res_meta.next_page_url">
            <button class="btn-sm page-link" @click.prevent="gotoNext" aria-label="Next">
              <span class>Next page</span>
              <i class="fas fa-arrow-alt-circle-right"></i>
            </button>
          </li>
        </ul>
      </nav>
      <nav aria-label="Page navigation">
        <ul class="pagination">
          <li>
            <span class="page-link btn-sm">Page: {{res_meta.current_page}} of {{res_meta.last_page}}</span>
          </li>
        </ul>
      </nav>
    </div>
    <hr class="m-0" />
    <h6 class="text-left mb-1">
      <i class="fas fa-copyright"></i> MCCHST (Developed by KAMEEN IT Solution 2348034932065)
    </h6>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchText: "",
      books: [],
      res_types: [],
      res_meta: [],
      read_resource: null,
      path: `./storage/library/`,
      cover: `/cover/`,
      res_link: ""
    };
  },
  mounted() {
    axios.get("library/res_type").then(res => {
      this.res_types = res.data.data;
      axios.get("library/get_resources").then(res => {
        this.books = res.data.data;
        this.res_meta = res.data;
      });
    });
  },
  methods: {
    res_read(read) {
      this.$emit("compChange", {
        link: this.path + read.res_type.res_type + "/" + read.res_files,
        comp: "read-resource"
      });
    },
    searchByText() {
      axios
        .get(`library/get_resources/by_search/${this.searchText}`)
        .then(res => {
          this.books = res.data.data;
          this.res_meta = res.data;
        });
    },
    gotoPrev() {
      axios.get(this.res_meta.prev_page_url).then(res => {
        this.books = res.data.data;
        this.res_meta = res.data;
      });
    },
    gotoNext() {
      axios.get(this.res_meta.next_page_url).then(res => {
        this.books = res.data.data;
        this.res_meta = res.data;
      });
    },
    gotoType(typeId) {
      axios.get(`library/get_resources/by_type/${typeId}`).then(res => {
        this.books = res.data.data;
        this.res_meta = res.data;
      });
    }
  }
};
</script>

<style scoped>
#readResource {
  min-width: 100%;
  min-height: 100%;
}
.img-rounded {
  width: 200px;
  height: 300px;
  border: 1px solid #260709;
}
.card {
  margin: 20px;
}
.read:hover {
  -moz-box-shadow: -1px 9px 45px -12px #260709;
  -webkit-box-shadow: -1px 9px 45px -12px #260709;
  box-shadow: -1px 9px 45px -12px #260709;
  border: 2px solid #260709;
  cursor: pointer;
}
.card-body {
  width: 200px;
  height: 100px;
  text-overflow: clip;
}
.image {
  display: block;
  width: 100%;
  height: auto;
}
.top-left {
  position: absolute;
  bottom: 0px;
  left: 0px;
  width: 200px;
  background: rgba(0, 0, 0, 0.8);
}
.overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: #008cba;
  overflow: hidden;
  width: 100%;
  height: 100%;
  -webkit-transform: scale(0);
  -ms-transform: scale(0);
  transform: scale(0);
  -webkit-transition: 0.3s ease;
  transition: 0.3s ease;
}

.container:hover .overlay {
  -webkit-transform: scale(1);
  -ms-transform: scale(1);
  transform: scale(1);
}

.text {
  color: white;
  font-size: 20px;
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  text-align: center;
}
</style>
