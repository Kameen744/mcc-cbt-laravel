<template>
  <!-- // Countdown Timer Until Date Vue JS
  // A PEN BY Dean modified by Kamal-->
  <div class="d-flex h-100">
    <div v-for="(time, key) in times" :key="key">
      <div
        class="btn btn-sm m-1"
        :class="time.time == 0 ? 'btn-danger' : 'btn-primary'"
      >
        <div class="px-2">
          <b>{{ time.time }}</b>
        </div>
        <div class="px-2">{{ time.text }}</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      times: [
        // { id: 0, text: "Days", time: 1 },
        { id: 0, text: "Hours", time: 1 },
        { id: 1, text: "Minutes", time: 1 },
        { id: 2, text: "Seconds", time: 1 },
      ],
      progress: 100,
      // isActive: false,
      timeinterval: undefined,
    };
  },
  props: {
    // currentExam: Object
    startTime: Date,
    endTime: Date,
  },
  methods: {
    updateTimer() {
      if (
        this.times[2].time > 0 ||
        this.times[1].time > 0 ||
        this.times[0].time > 0
        // this.times[0].time > 0
      ) {
        this.getTimeRemaining();
        this.updateProgressBar();
      } else {
        clearTimeout(this.timeinterval);
        // let outTime =
        //   this.times[0].time +
        //   " : " +
        //   this.times[1].time +
        //   " : " +
        //   this.times[0].time;
        this.$emit("timeEnd");
        this.times[2].time = this.times[1].time = this.times[0].time = 0;
        this.progress = 0;
      }
    },
    getTimeRemaining() {
      this.startTime.setSeconds(this.startTime.getSeconds() + 1);
      let t =
        Date.parse(new Date(this.endTime)) -
        Date.parse(new Date(this.startTime));
      if (t >= 0) {
        this.times[2].time = Math.floor((t / 1000) % 60); //seconds
        this.times[1].time = Math.floor((t / 1000 / 60) % 60); //minutes
        this.times[0].time = Math.floor((t / (1000 * 60 * 60)) % 24); //hours
      } else {
        this.times[2].time = this.times[1].time = this.times[0].time;
        this.progress = 0;
      }
      this.$emit("timeElapse", this.startTime);
    },
    updateProgressBar() {
      let startTime = Date.parse(new Date(this.startTime));
      let currentTime = Date.parse(new Date());
      let endTime = Date.parse(new Date(this.endTime));
      let interval = parseFloat(
        ((currentTime - startTime) / (endTime - startTime)) * 100
      ).toFixed(2);
      this.progress = 100 - interval;
    },
  },
  created() {
    this.timeinterval = setInterval(this.updateTimer, 1000);
  },
};
</script>

<style scoped></style>
