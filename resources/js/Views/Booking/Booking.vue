<template>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <BookingDataTable
        :create="create"
        :deletet="deletet"
        :updated="updated"
      />
    </div>
  </div>
</template>

<script>
import BookingDataTable from "./Table/Booking.vue";

export default {
  name: "Booking",
  components: {
    BookingDataTable,
  },
  props: {
    create: {
      type: String,
      default: 0,
    },
    deletet: {
      type: String,
      default: 0,
    },
    updated: {
      type: String,
      default: 0,
    },
  },
};
</script>
