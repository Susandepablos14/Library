<template>
  <form>
    <!-- Modal -->
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header py-2">
            <h5
              class="modal-title title-page text-secondary"
              id="exampleModalLabel"
            >
              Crear Reservación
            </h5>
            <a
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </a>
          </div>
          <div class="modal-body">
            <div class="mb-3">
                <label for="book_id" class="form-label">Libro</label>
                <select
                    v-model="form.book_id"
                    class="form-control"
                    id="book_id"
                    name="book_id"
                >
                    <option v-for="book in books" :value="book.id">{{ book.title }}</option>
                </select>
              </div>
            </div>
          <div class="modal-footer">
            <a
              class="btn btn-danger text-white btn-icon-split mb-4"
              data-dismiss="modal"
            >
              <span class="text font-montserrat font-weight-bold"
                >Cancelar</span
              >
            </a>
            <a
              v-on:click.prevent="createBooking()"
              class="btn btn-primary text-white btn-icon-split mb-4"
            >
              <span class="text font-montserrat font-weight-bold">Crear</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

  <script>
import axios from "axios";
import toastr from "toastr";

export default {
  name: "BookingCreate",
  created() {
    this.getKeeps();
  },
  data() {
    return {
      form: this.getClearFormObject(),
      books: [],
    };
  },
  methods: {
    createBooking() {
      const formData = new FormData();
      formData.append("book_id", this.form.book_id);
      axios
        .post("/booking/create", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          this.image = null;
          this.form = this.getClearFormObject();
          toastr.success("Creado exitosamente.");
          $("#exampleModal").modal("hide");
          this.$emit("GetCreatedRol");
          window.location.reload();
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          }
          for (error in this.errors) {
            toastr.error(this.errors[error]);
          }
        });
    },
    getKeeps() {
        var urlBooks = "/book/get";
        axios
          .all([
            axios.get(urlBooks),
          ])
          .then(axios.spread((responseBooks) => {
            this.books = responseBooks.data.data.map(book => ({
              title: book.attributes.title,
              id: book.id
            }));
          }))
          .catch((error) => {});
      },
    getClearFormObject() {
      return {
        name: "",
        book_id: "",
      };
    },
  },
};
</script>

<style>
    @import "~toastr/build/toastr.css";
</style>
