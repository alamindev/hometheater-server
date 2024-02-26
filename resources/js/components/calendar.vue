<template>
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h3>Schedule of availabilty</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <div class="row">
                <div class="col-md-6 d-flex justify-content-md-end">
                  <div>
                    <h3 class="pb-2">Date:</h3>
                    <DatePicker
                      :min-date="new Date()"
                      v-model="date"
                      mode="date"
                      :max-date="maxDate"
                      :attributes="attrs"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="col-8">
                    <h3 class="pb-2">Time:</h3>
                    <ul class="custom--style">
                      <li
                        v-for="t in times"
                        :key="t.value"
                        :class="t.isbook ? 'active' : ''"
                        class="pb-2"
                      >
                        <button
                          :class="t.isbook ? 'is_time__active' : ''"
                          @click="dataTime(t.value, t.isbook)"
                          class="btn--style border-brand-color"
                        >
                          {{ t.value }}
                        </button>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <p v-if="calendarerr" class="text-center text-danger">
                Please select date!
              </p>
              <div class="d-flex justify-content-center pt-3">
                <button
                  type="button"
                  class="btn btn-success"
                  :disabled="datetime.length === 0"
                  @click="SubmitSchedule"
                >
                  Submit
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import DatePicker from "v-calendar/lib/components/date-picker.umd";
Vue.component("date-picker", DatePicker);
export default {
  components: {
    DatePicker,
  },
  data() {
    return {
      time: "",
      date: new Date(),
      times: [
        {
          value: "9am",
          isbook: false,
        },
        {
          value: "10am",
          isbook: false,
        },
        {
          value: "11am",
          isbook: false,
        },
        {
          value: "12pm",
          isbook: false,
        },
        {
          value: "1pm",
          isbook: false,
        },
        {
          value: "2pm",
          isbook: false,
        },
        {
          value: "3pm",
          isbook: false,
        },
        {
          value: "4pm",
          isbook: false,
        },
      ],
      attrs: [],
      datetime: [],
      calendarerr: false,
      is_book: false,
    };
  },
  computed: {
    maxDate() {
      return new Date(moment().add(1, "months"));
    },
    changeDateTime() {
      const { time, date, is_book } = this;
      return {
        time,
        date,
        is_book,
      };
    },
    changeDate() {
      const { date } = this;
      return {
        date,
      };
    },
  },
  watch: {
    changeDate: {
      handler: function (val) {
        let times = [...this.times];
        this.times = times.map((el) => {
          el.isbook = false;
          return el;
        });
        this.time = "";
        this.update_datetime([]);
        this.fetchTime({ date: moment(val.date).format("YYYY-MM-DD") });
        this.calendarerr = false;
      },
      deep: true,
    },
    changeDateTime: {
      handler: function (val) {
        if (val.date == null) {
          this.calendarerr = true;
        } else {
          let date = moment(val.date).format("YYYY-MM-DD");

          if (val.date != "" && val.time != "") {
            let time = moment(val.time, ["h:mm A"]).format("HH:mm");
            const datetime = {
              date: date,
              time: time,
              is_book: val.is_book,
            };
            this.update_datetime(datetime);
          }
        }
      },
      deep: true,
    },
  },
  methods: {
    update_datetime(obj) {
      if (Array.isArray(obj)) {
        this.datetime = [];
      } else {
        let filtered = this.datetime.filter((el) => el.time === obj.time);
        if (filtered.length > 0) {
          this.datetime = this.datetime.filter(
            (el) => el.time !== filtered[0].time
          );
        } else {
          this.datetime.push(obj);
        }
      }
    },
    dataTime(val, isbook) {
      this.is_book = isbook;
      let times = [...this.times];
      this.times = times.map((el) => {
        if (el.value === val) {
          el.isbook = !el.isbook;
        }
        return el;
      });
      this.time = val;
    },
    timeMatch(res) {
      if (res.length > 0) {
        let timearr = res.map((el) => moment(el.time, ["hh"]).format("ha"));
        let times = [...this.times];
        this.times = times.map((el) => {
          el.isbook = false;
          var match = timearr.includes(el.value);
          if (match) {
            el.isbook = true;
          }
          return el;
        });
      } else {
        let times = [...this.times];
        this.times = times.map((el) => {
          el.isbook = false;
          return el;
        });
      }
    },
    async SubmitSchedule() {
      try {
        let data = await axios.post("/schedule/store", {
          datetime: this.datetime,
        });
        location.reload();
      } catch (e) {}
    },
    async fetchTime(date) {
      let { data } = await axios.post("/calendar/time", {
        date,
      });
      if (data.success == true) {
        this.timeMatch(data.times);
      } else {
        this.timeMatch([]);
      }
    },
    async fetchAttributes() {
      let { data } = await axios.get("/calendar/attributes");
      if (data.success == true) {
        if (data.dates.length > 0) {
          let attri = data.dates.map((el) => {
            return {
              dates: new Date(moment(el.date).format("YYYY, MM, DD")),
              highlight: {
                color: "red",
                fillMode: "solid",
                contentClass: "italic",
              },
            };
          });
          this.attrs = attri;
        }
      } else {
        return false;
      }
    },
  },
  created() {
    this.fetchAttributes();
    this.fetchTime({ date: moment(new Date()).format("YYYY-MM-DD") });
  },
};
</script>
<style scoped>
.custom--style {
  display: grid;
  grid-template-columns: 1fr 1fr;
  list-style-type: none;
}
.custom--style li {
  padding: 5px 10px;
}
.custom--style li .btn--style {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 10px;
  padding: 17px 5px;
  background: transparent;
  font-weight: bold;
}
.bg-red-500 {
  background: red !important;
  color: white;
}
.border-brand-color:hover {
  border: 1px solid #4e81ee;
}
.active .btn--style {
  background: red !important;
  color: white;
}
.is_time__active {
  background: #e53e3e !important;
  cursor: not-allowed !important;
  color: white !important;
}
</style>
