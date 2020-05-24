<template>
    <div>
        <form @submit="checkForm" @submit.prevent="addClient" method="post">
            <div v-if="errors.length">
                <b>Please correct the following error(s):</b>
                <ul>
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
            </div>
            <p>
                <label for="name">Ful Name</label>
                <input
                    type="text"
                    class="form-control mb-2"
                    placeholder="Enter your full name"
                    v-model="name"
                />
            </p>
            <p>
                <label for="age">Age</label>
                <input
                    type="text"
                    class="form-control mb-2"
                    placeholder="Enter your age"
                    v-model="age"
                />
            </p>
            <p>
                <label for="gender">Gender</label>
            </p>
            <p>
                <select name="gender" id="gender" v-model="gender">
                    <option>Male</option>
                    <option>Female</option>
                </select>
            </p>
            <p>
                <label for="city">City</label>
                <vue-bootstrap-typeahead
                    v-model="query"
                    placeholder="Enter your city"
                    :data="cities"
                    :serializer="item => item.name"
                />
            </p>
            <button class="btn btn-primary" type="submit">Save</button>

            <div v-if="success" class="alert alert-success mt-3">
                {{ message }}
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            errors: [],
            fields: {},
            cities: [],
            name: null,
            age: null,
            gender: null,
            query: "",
            // change for the location of the person
            lat: "43.70011",
            lng: "-79.4163",
            success: false,
            message: ""
        };
    },
    methods: {
        checkForm: function(e) {
            if (this.name && this.age && this.gender && this.query) {
                return true;
            }

            this.errors = [];

            if (!this.name) {
                this.errors.push("Name is required.");
            }
            if (!this.age) {
                this.errors.push("Age is required.");
            }
            if (!this.gender) {
                this.errors.push("Gender is required.");
            }
            if (!this.query) {
                this.errors.push("City is required.");
            }
            e.preventDefault();
        },
        addClient() {
            this.success = false;
            this.message = "";
            axios
                .post("/api/clients", {
                    name: this.name,
                    age: this.age,
                    gender: this.gender,
                    city: this.query
                })
                .then(res => {
                    this.errors = [];
                    this.success = true;
                    this.message = "Successfully saved client.";
                })
                .catch(error => {
                    this.success = false;
                    this.message =
                        "Problems saving the client, try again later.";
                });
        }
    },
    watch: {
        query(newQuery) {
            if (this.query.length > 0) {
                axios
                    .get("/api/sugerencias", {
                        params: {
                            q: newQuery,
                            latitude: this.lat,
                            longitude: this.lng
                        }
                    })
                    .then(response => {
                        this.cities = response.data.data;
                    });
            }
        }
    }
};
</script>
