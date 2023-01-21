export default {
    methods: {
        fireMessage(content, type) {
            let message = document.getElementById(type == "success" ? "success_message" : "error_message");
            message.innerHTML = content;

            message.classList.toggle("show_message");
            setTimeout(() => {
                message.classList.toggle("show_message");
            }, 3000);
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

        formErrors(errors) {
            let keys = Object.keys(errors);
            keys.forEach((key) => {
                errors[key] = [errors[key]];
            });

            return errors;
        },

        getImageParagraph(errors, name) {
            if (errors.hasOwnProperty("image")) {
                return `<span class = "validation-error">  ${errors.image[0]}  </span> `;
            } else if (name) {
                return `<span >  ${name}  </span> `;
            } else {
                return `<span > No image selected </span> `;
            }
        },

        handleServerData(formData, serverData) {
            let formKeys = Object.keys(formData);
            let servermKeys = Object.keys(serverData);

            formKeys.forEach((formKey) => {
                if (servermKeys.indexOf(formKey) !== -1) {
                    formData[formKey] = serverData[formKey];
                }
            });
        },
    },
};
