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
              Crear Prestamo
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
                <label for="booking_id" class="form-label">Libro</label>
                <select
                    v-model="form.booking_id"
                    class="form-control"
                    id="booking_id"
                    name="booking_id"
                >
                    <option v-for="booking in bookings" :value="booking.id">{{ booking.title }} - {{ booking.user }}</option>
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
              v-on:click.prevent="createLoan()"
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
  name: "LoanCreate",
  created() {
    this.getKeeps();
  },
  data() {
    return {
      form: this.getClearFormObject(),
      bookings: [],
    };
  },
  methods: {
    createLoan() {
      const formData = new FormData();
      formData.append("booking_id", this.form.booking_id);
      axios
        .post("/loan/create", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          this.error = null;
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
        var urlBooks = "/booking/get";
        axios
          .all([
            axios.get(urlBooks),
          ])
          .then(axios.spread((responseBooks) => {
        this.bookings = responseBooks.data.data
            .filter(booking => {
                return booking.relationships.book.relationships.copies.some(copy => {
                    return copy.attributes.status === "Reservado" && copy.attributes.quantity > 0;
                });
            })
            .map(booking => ({
                title: booking.relationships.book.attributes.title,
                user: booking.relationships.user.attributes.name,
                id: booking.id
            }));
    }))
    .catch((error) => {
        // Manejar errores
    });
},
    getClearFormObject() {
      return {
        name: "",
        booking_id: "",
      };
    },
  },
};
</script>

<style>
    @import "~toastr/build/toastr.css";
</style>
