<template>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <LoanDataTable
        :create="create"
        :deletet="deletet"
        :updated="updated"
      />
    </div>
  </div>
</template>

<script>
import LoanDataTable from "./Table/Loan.vue";

export default {
  name: "Loan",
  components: {
    LoanDataTable,
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
