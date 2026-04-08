
<script setup>
import { ref } from 'vue'
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
const datum = ref('')
const veranstaltung = ref('')
const bild = ref(null)
const text = ref('')
const sendEmail = ref(false)
const eventRepeat = ref(false)


//Anzeige
const message = ref('')
const messages = ref('')

async function insertEvents(){


    if(!datum.value || !veranstaltung.value || !text.value){
        message.value = "Eingaben prüfen!"
        return;
    }

    const formData = new FormData()
    formData.append('datum', datum.value)
    formData.append('veranstaltung', veranstaltung.value)
    formData.append('text', text.value)
    formData.append('sendEmailRepeat', eventRepeat)
    if (sendEmail.value) {
        formData.append('sendEmail', 'akzeptiert')
    }



    if (bild.value) {
        formData.append('bild', bild.value)
    }


    const response = await fetch(`api/newsletter`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        body: formData
    })

    //HTTP Status
    if(!response.ok){
        message.value = "Fehler"
    }

    const data = await response.json()

    message.value = data.message
    messages.value = data.messages

}
function handleBildChange(event) {
    bild.value = event.target.files[0] ?? null
}

</script>

<template>
    <h2>Aktuelles einfügen *Neu reaktiv*</h2>

    <div class="formContainer">
        <form   @submit.prevent="insertEvents" id="form2"  name="form2" enctype="multipart/form-data">

            <label id="datumLabel">Datum</label>
            <input
                type="date"
                name="datum"
                placeholder="Datum eingeben"
                required
                v-model="datum"
            >

            <label id="veranstaltungLabel">Veranstaltung</label>
            <input
                type="text"
                name="veranstaltung"
                placeholder="Veranstaltung eingeben"
                required
                v-model="veranstaltung"
            >

            <label id="bildLabel">Bild einfügen</label>
            <input
                type="file"
                name="bild"
                v-on:change="handleBildChange"
            >

            <input type="hidden" name="form_name_2" value="form2">

            <label id="textLabel">Text:</label>
            <textarea
                name="text"
                placeholder="Beschreibung hinzufügen"
                v-model="text"
            ></textarea>

            <label id="checkLabel" class="checkbox-container">
                <input
                    type="checkbox"
                    name="sendEmail"
                    value="akzeptiert"
                    v-model="sendEmail"
                >
                <span>Email senden an alle Newsletter-Abonnenten.</span>
            </label>

            <label id="checkLaBEL" class="checkbox-container">
                <input
                    type="checkbox"
                    name="sendEmailRepeat"
                    value="akzeptiert"
                    v-model="eventRepeat"
                >
                <span>Wiederkehrende Veranstaltung?</span>
            </label>

            <input type="submit" value="Einpflegen">

            <div v-if="message">
                {{ message }}
            </div>

            <div v-for="m in messages" :key="m.text">
                {{ m.text }}
            </div>
        </form>
    </div>
</template>

<style scoped>

</style>
