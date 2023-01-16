export default {
    methods: {
        showSuccessMessage(message) {
            document.getElementById("success_message").innerHTML = message;

            document
                .getElementById("success_message")
                .classList.toggle("show_success_message");
            setTimeout(() => {
                document
                    .getElementById("success_message")
                    .classList.toggle("show_success_message");
            }, 2000);
        },

        TwelveHoursFormetedTime(item) {
            const dateValue = item;
            var hours = dateValue.getHours();
            var minutes = dateValue.getMinutes();
            var ampm = hours >= 12 ? "PM" : "AM";
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? "0" + minutes : minutes;
            var strTime = hours + ":" + minutes + " " + ampm;
            return strTime;
        },

        formatedDate(dateItem) {
            let dateValue = new Date(dateItem);
            let YearMonthDay =
                dateValue.getFullYear() +
                "-" +
                (dateValue.getMonth() + 1) +
                "-" +
                dateValue.getDate();

            let timestamp =
                YearMonthDay + " " + this.TwelveHoursFormetedTime(dateValue);
            return timestamp;
        },

        getUniqueArray(records) {
            let uniqueArray = [];
            let index = -1;

            records.forEach((record) => {
                index = uniqueArray.findIndex(function (item) {
                    return item.id == record.id;
                });

                if (index == -1) {
                    uniqueArray.push(record);
                }
            });

            return uniqueArray;
        },

        getPermissionsNames() {
            let permissions = [];
            window.User.permissions.forEach((permission) => {
                permissions.push(permission.name);
            });

            return permissions;
        },

        can(ability) {
            if (this.getPermissionsNames.length) {
                return this.getPermissionsNames.indexOf(ability) !== -1;
            } else {
                return true;
            }
        },
    },
};