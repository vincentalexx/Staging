import axios from 'axios';
import AppListing from '../app-components/Listing/AppListing';

Vue.component('discipleship-detail-listing', {
    mixins: [AppListing],
    props: ['divisiData', 'data', 'tempAttendance'],
    data() {
        let date = new Date();
        let currentMonth = (date.getMonth() + 1)
        let currentYear = date.getFullYear()
        return {
            daysInPeriod: [],
            month: currentMonth,
            year: currentYear,
            nameOfMonth: '',
            holidayDate: [],
            work_day_type: '',
            period_name: '',
            isAfterPeriod: false,
            isBeforePeriod: false,
            judulPembinaan: [],
            totalHadir: [],
            discipleshipList: [],
            selectedDiscipleship: '',

            datePickerConfig: {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d M Y"
            },
        }
    },
    mounted() {
        this.work_day_type = 'Bulan'
        this.getDiscipleshipList()
    },
    computed: {
        items() {
            return (this.collection.data ? this.collection.data.data ? this.collection.data.data : this.collection : this.collection)
        },
        getCongregationAttendancePeriod() {
            let calendarData = []
            if (this.items && this.daysInPeriod && this.collection.attendance) {
                this.items.map((user, u) => {
                    calendarData[u] = []
                    this.daysInPeriod.map((day, d) => {
                        calendarData[u].push(
                            this.collection.attendance[u].filter((attendance) =>
                                new Date(attendance.tanggal).getTime() === new Date(day).getTime()
                            )
                        )
                    })
                })
            }
            return calendarData
        },
    },
    methods: {
        getCalendarData() {
            this.getMonthArray(this.year, this.month)
            this.getTotalHadir(this.year, this.month)
        },
        getMonthArray(year, month) {
            let days = [];

            let dateOfMonth = moment(year + "-" + month, "YYYY-MM").daysInMonth()

            for (let i = 1; i <= dateOfMonth; i++) {
                let myDate = moment(year + "-" + month, "YYYY-MM")
                            .date(i)
                            .format("YYYY-MM-DD")

                let dt = moment(myDate)
                let day = 0
                // if ()

                if (dt.format("d") == 0) {
                    days.push(myDate)
                }
            }
            
            let nameOfMonth = this.nameOfMonth

            switch (month) {
                case 1:
                    nameOfMonth = 'January'
                    break;
                case 2:
                    nameOfMonth = 'February'
                    break;
                case 3:
                    nameOfMonth = 'March'
                    break;
                case 4:
                    nameOfMonth = 'April'
                    break;
                case 5:
                    nameOfMonth = 'May'
                    break;
                case 6:
                    nameOfMonth = 'June'
                    break;
                case 7:
                    nameOfMonth = 'July'
                    break;
                case 8:
                    nameOfMonth = 'August'
                    break;
                case 9:
                    nameOfMonth = 'September'
                    break;
                case 10:
                    nameOfMonth = 'October'
                    break;
                case 11:
                    nameOfMonth = 'November'
                    break;
                case 12:
                    nameOfMonth = 'December'
                    break;
            }

            this.nameOfMonth = nameOfMonth
            this.daysInPeriod = days
            this.filter("month", this.month)
            this.filter("year", this.year)
        },
        getDiscipleshipList() {
            axios({
                method: "GET",
                url: "/admin/discipleship-details/get-discipleship-list",
                params: {
                    divisi: this.divisiData,
                }
            }).then(response => {
                this.discipleshipList = response.data
                this.selectedDiscipleship = response.data[0].id
                this.getCalendarData()
            })
        },
        getTotalHadir(year, month) {
            console.log(this.selectedDiscipleship)
            axios({
                method: "GET",
                url: "/admin/discipleship-details/get-total-hadir",
                params: {
                    year: year,
                    month: month,
                    discipleship: this.selectedDiscipleship,
                }
            }).then(response => {
                console.log(response)
                this.totalHadir = response.data.totalHadir
                this.judulPembinaan = response.data.judulPembinaan
            })
        },
        prevMonth() {
            let year = this.year
            let month = this.month

            month -= 1
            if (month == 0) {
                month = 12
                year -= 1
            }

            this.month = month
            this.year = year

            this.getMonthArray(year, month)
            this.getTotalHadir(year, month)
        },
        nextMonth() {
            let year = this.year
            let month = this.month

            month += 1
            if (month > 12) {
                month = 1
                year += 1
            }

            this.month = month
            this.year = year

            this.getMonthArray(year, month)
            this.getTotalHadir(year, month)
        },
        currentMonth() {
            let date = new Date();
            let year = this.year
            let month = this.month

            month = (date.getMonth() + 1)
            year = date.getFullYear()

            this.month = month
            this.year = year

            this.getMonthArray(year, month)
            this.getTotalHadir(year, month)
        },
        importExcelPopup() {
            this.$swal({
                title: 'Select CSV',
                text: '(No. ID, Tanggal, Scan Masuk, Scan Pulang)',
                input: 'file',
                inputAttributes: {
                    accept: 'z/*',
                    'aria-label': 'Upload your excel data'
                },
                showLoaderOnConfirm: true,
                showCancelButton: true,
                cancelButtonColor: '#d33',
                preConfirm: (stock) => {
                    let formData = new FormData();
                    formData.append('file', stock);
                    return axios.post('/admin/work-days/import-attendance', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then((response) => {
                        axios.get('/admin/work-days')
                            .then((res) => {
                                this.collection = res.data.data.data
                                return true
                            })
                    })
                },
                allowOutsideClick: () => !this.$swal.isLoading()
            }).then((result) => {
                if (this.errorData == 'none') {
                    this.$swal({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        type: 'error',
                        title: 'You must send the file excel'
                    })
                } else
                    if (this.errorData == false) {
                        this.$swal({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            type: 'success',
                            title: 'Data Stock Opname has been saved'
                        })
                    } else if (this.errorData == true) {
                        this.$swal({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            type: 'error',
                            title: 'There is some error when import excel'
                        })
                    }
            })
        },
    },
    watch: {
        work_day_type(val) {
            this.getCalendarData()
        },
        selectedDiscipleship(val) {
            this.getTotalHadir(this.year, this.month)
        }
    },
});