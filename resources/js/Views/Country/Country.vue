<template>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <CountryDataTable
        :create="create"
        :deletet="deletet"
        :updated="updated"
      />
    </div>
  </div>
</template>

<script>
import CountryDataTable from "./Table/Country.vue";

export default {
  name: "Country",
  components: {
    CountryDataTable,
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
