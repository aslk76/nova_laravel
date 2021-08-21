<template>
<v-app style="background: 0!important; padding-left: 10px; padding-right: 10px;">
    <div style="background: rgba(40, 41, 43, 0.9);border-radius: 5px;">
        <div style="text-align: center; padding-top: 10px;">
            <v-btn
                elevation="6"
                fab
                large
                tile
                text
                style="color: red; font-size: 10px;"
                @click="showPayments('horde')"
            ><img :src="'/images/hordeicon64.png'"></v-btn>
            <v-divider vertical style="padding: 5px;"></v-divider>
            <v-btn
                elevation="6"
                fab
                large
                text
                tile
                style="color:blue; font-size: 10px;"
                @click="showPayments('alliance')"
            ><img :src="'/images/allianceicon64.png'"></v-btn>
            <v-divider vertical style="padding: 5px;"></v-divider>
            <v-btn
                elevation="6"
                fab
                large
                tile
                text
                style="color:black; font-size: 10px;"
                @click="showPayments('all')"
            ><img :src="'/images/allicon64.png'"></v-btn>
        </div>
        <!-- <div style="text-align: center; padding-top 10px;"> -->
        <span style="    padding-left: 60px;font-size: 20px;color: white;">How much you paid in a server?</span>
        <v-autocomplete
            v-model="selectedRealm"
            class="realmSelector blackComponent"
            style="top: 0; left: 0;"
            :items="realms"
            label="Select a realm"
            single-line
        ></v-autocomplete>
        <v-btn elevation="6" fab x-small tile text style="color:black; font-size: 10px; position: absolute; top: 120px; left: 405px;" @click="getPaymentsRealm()">
            <span class="material-icons">
                search
            </span>
        </v-btn>
         <table class="table table-bordered table-dark table-custom" style="width: 20%; text-align: center; margin-top: 20px; margin-left: 20px;">
            <tbody>
                <tr v-for="item in realmItems">
                    <td>{{item.total}}</td>
                </tr>
            </tbody>
        </table>
        <!-- </div> -->
        <v-card-title>
        <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search for Boost Realm"
            single-line
            hide-details
            class="blackComponent"
        ></v-text-field>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="items"
            :items-per-page="50"
            :search="search"
            class="elevation-1 vueTable"
        >
        <template v-slot:item.paid="{ item }">
            <v-text-field
                v-model="item.paid"
          ></v-text-field>
        </template>

        <template v-slot:item.actions="{ item }">
            <v-btn elevation="2" fab x-small class="save-button-dialog" color="grey darken-1" @click="sendPayment(item)">
                <span class="material-icons">
                    save
                </span>
            </v-btn>
        </template>
        </v-data-table>
        <v-snackbar v-model="snackbar">
        {{ text }}
        <template v-slot:action="{ attrs }">
            <v-btn
            color="pink"
            text
            v-bind="attrs"
            @click="snackbar = false"
            >
            Close
            </v-btn>
        </template>
        </v-snackbar>
        <v-snackbar v-model="snackbarBadValue">
        {{ textBadValue }}
        <template v-slot:action="{ attrs }">
            <v-btn
            color="pink"
            text
            v-bind="attrs"
            @click="snackbarBadValue = false"
            >
            Close
            </v-btn>
        </template>
        </v-snackbar>
        </div>
        <v-dialog v-model="loading" fullscreen full-width no-click-animation>
        <v-container fluid fill-height style="background-color: rgba(255, 255, 255, 0.5);">
            <v-layout justify-center align-center>
                <v-progress-circular
                    indeterminate
                    color="primary">
                </v-progress-circular>
            </v-layout>
        </v-container>
        </v-dialog>
    </v-app>
</template>

<script>
  export default {
    data () {
      return {
            dialog: false,
            search: '',
            items: [],
            actualFaction : '',
            headers: [
                { text: 'Booster', value: 'booster'},
                { text: 'Previous Balance', value: 'pre_balance', filterable: false },
                { text: 'Pending', value: 'pending', filterable: false },
                { text: 'Paid', value: 'paid', filterable: false },
                { text: 'Actions', value: 'actions', filterable: false },
            ],
            snackbar: false,
            text: `There was an error in your input. Please, recheck it or contact a Developer.`,
            snackbarBadValue: false,
            loading: false,
            textBadValue: `The amount of payment is over the amount he needs to get paid. Please, recheck it or contact a Developer.`,
            selectedRealm: 'Aegwynn [A]',
            realmItems: [],
            realms: ["Aegwynn [A]", "AeriePeak [A]", "Agamaggan [A]", "Aggra [A]",
              "Aggramar [A]", "Ahn'Qiraj [A]", "Al'Akir [A]", "Alexstrasza [A]", "Alleria [A]", "Alonsus [A]",
              "Aman'Thul [A]", "Ambossar [A]", "Anachronos [A]", "Anetheron [A]", "Antonidas [A]", "Anub'arak [A]",
              "Arak-arahm [A]", "Arathi [A]", "Arathor [A]", "Archimonde [A]", "Area52 [A]", "ArgentDawn [A]",
              "Arthas [A]", "Arygos [A]", "Aszune [A]", "Auchindoun [A]", "AzjolNerub [A]", "Azshara [A]",
              "Azuremyst [A]", "Baelgun [A]", "Balnazzar [A]",
              "Blackhand [A]", "Blackmoore [A]", "Blackrock [A]", "Blade'sEdge [A]", "Bladefist [A]",
              "Bloodfeather [A]", "Bloodhoof [A]", "Bloodscalp [A]", "Blutkessel [A]", "Boulderfist [A]",
              "BronzeDragonflight [A]", "Bronzebeard [A]", "BurningBlade [A]", "BurningLegion [A]",
              "BurningSteppes [A]", "C'Thun [A]", "ChamberofAspects [A]", "Chantséternels [A]", "Cho'gall [A]",
              "Chromaggus [A]", "ColinasPardas [A]", "ConfrérieduThorium [A]", "ConseildesOmbres [A]", "Crushridge [A]",
              "CultedelaRivenoire [A]", "Daggerspine [A]", "Dalaran [A]",
              "Dalvengyr [A]", "DarkmoonFaire [A]", "Darksorrow [A]", "Darkspear [A]", "DasKonsortium [A]",
              "DasSyndikat [A]", "Deathwing [A]", "DefiasBrotherhood [A]",
              "Dentarg [A]", "DerabyssischeRat [A]", "DerMithrilorden [A]", "DerRatvonDalaran [A]", "Destromath [A]",
              "Dethecus [A]", "DieAldor [A]", "DieArguswacht [A]",
              "DieewigeWacht [A]", "DieNachtwache [A]", "DieSilberneHand [A]", "DieTodeskrallen [A]", "Doomhammer [A]",
              "Draenor [A]", "Dragonblight [A]", "Dragonmaw [A]",
              "Drak'thul [A]", "Drek'Thar [A]", "DunModr [A]", "DunMorogh [A]", "Dunemaul [A]", "Durotan [A]",
              "EarthenRing [A]", "Echsenkessel [A]", "Eitrigg [A]",
              "Eldre'Thalas [A]", "Elune [A]", "EmeraldDream [A]", "Emeriss [A]", "Eonar [A]", "Eredar [A]",
              "Executus [A]", "Exodar [A]", "FestungderStürme [A]",
              "Forscherliga [A]", "Frostmane [A]", "Frostmourne [A]", "Frostwhisper [A]", "Frostwolf [A]", "Garona [A]",
              "Garrosh [A]", "Genjuros [A]", "Ghostlands [A]",
              "Gilneas [A]", "Gorgonnash [A]", "GrimBatol [A]", "Gul'dan [A]", "Hakkar [A]", "Haomarush [A]",
              "Hellfire [A]", "Hellscream [A]", "Hyjal [A]", "Illidan [A]",
              "Jaedenar [A]", "Kael'thas [A]", "Karazhan [A]", "Kargath [A]", "Kazzak [A]", "Kel'Thuzad [A]",
              "Khadgar [A]", "KhazModan [A]", "Khaz'goroth [A]", "Kil'jaeden [A]",
              "Kilrogg [A]", "KirinTor [A]", "Kor'gall [A]", "Krag'jin [A]", "Krasus [A]", "KulTiras [A]",
              "KultderVerdammten [A]", "LaCroisadeécarlate [A]", "LaughingSkull [A]",
              "LesClairvoyants [A]", "LesSentinelles [A]", "Lightbringer [A]", "Lightning'sBlade [A]", "Lordaeron [A]",
              "LosErrantes [A]", "Lothar [A]", "Madmortem [A]",
              "Magtheridon [A]", "Mal'Ganis [A]", "Malfurion [A]", "Malorne [A]", "Malygos [A]", "Mannoroth [A]",
              "MarécagedeZangar [A]", "Mazrigos [A]", "Medivh [A]",
              "Minahonda [A]", "Moonglade [A]", "Mug'thol [A]", "Nagrand [A]", "Nathrezim [A]", "Naxxramas [A]",
              "Nazjatar [A]", "Nefarian [A]", "Nemesis [A]", "Neptulon [A]",
              "Nera'thor [A]", "Ner'zhul [A]", "Nethersturm [A]", "Nordrassil [A]", "Norgannon [A]", "Nozdormu [A]",
              "Onyxia [A]", "Outland [A]", "Perenolde [A]",
              "PozzoDell'Eternità [A]", "Proudmoore [A]", "Quel'Thalas [A]", "Ragnaros [A]", "Rajaxx [A]",
              "Rashgarroth [A]", "Ravencrest [A]", "Ravenholdt [A]", "Rexxar [A]",
              "Runetotem [A]", "Sanguino [A]", "Sargeras [A]", "Saurfang [A]", "ScarshieldLegion [A]", "Sen'jin [A]",
              "Shadowsong [A]", "ShatteredHalls [A]", "ShatteredHand [A]",
              "Shattrath [A]", "Shen'dralar [A]", "Silvermoon [A]", "Sinstralis [A]", "Skullcrusher [A]",
              "Spinebreaker [A]", "Sporeggar [A]", "SteamwheedleCartel [A]", "Stormrage [A]",
              "Stormreaver [A]", "Stormscale [A]", "Sunstrider [A]", "Suramar [A]", "Sylvanas [A]", "Taerar [A]",
              "Talnivarr [A]", "TarrenMill [A]", "Teldrassil [A]", "Templenoir [A]",
              "Terenas [A]", "Terokkar [A]", "Terrordar [A]", "TheMaelstrom [A]", "TheSha'tar [A]", "TheVentureCo [A]",
              "Theradras [A]", "Thrall [A]", "Throk'Feroth [A]",
              "Thunderhorn [A]", "Tichondrius [A]", "Tirion [A]", "Todeswache [A]", "Trollbane [A]", "Turalyon [A]",
              "Twilight'sHammer [A]", "TwistingNether [A]", "Tyrande [A]",
              "Uldaman [A]", "Ulduar [A]", "Uldum [A]", "Un'Goro [A]", "Varimathras [A]", "Vashj [A]", "Vek'lor [A]",
              "Vek'nilash [A]", "Vol'jin [A]", "Wildhammer [A]", "Wrathbringer [A]",
              "Xavius [A]", "Ysera [A]", "Ysondre [A]", "Zenedar [A]", "ZirkeldesCenarius [A]", "Zul'jin [A]",
              "Zuluhed [A]", "Азурегос [A]", "Борейскаятундра [A]", "ВечнаяПесня [A]",
              "Галакронд [A]", "Голдринн [A]", "Гордунни [A]", "Гром [A]", "Дракономор [A]", "Король-лич [A]",
              "ПиратскаяБухта [A]", "Подземье [A]", "Разувий [A]", "Ревущийфьорд [A]",
              "СвежевательДуш [A]", "Седогрив [A]", "СтражСмерти [A]", "Термоштепсель [A]", "ТкачСмерти [A]",
              "ЧерныйШрам [A]", "Ясеневыйлес [A]", "Aegwynn [H]", "AeriePeak [H]",
              "Agamaggan [H]", "Aggra [H]", "Aggramar [H]", "Ahn'Qiraj [H]", "Al'Akir [H]", "Alexstrasza [H]",
              "Alleria [H]", "Alonsus [H]", "Aman'Thul [H]", "Ambossar [H]", "Anachronos [H]",
              "Anetheron [H]", "Antonidas [H]", "Anub'arak [H]", "Arak-arahm [H]", "Arathi [H]", "Arathor [H]",
              "Archimonde [H]", "Area52 [H]", "ArgentDawn [H]", "Arthas [H]", "Arygos [H]",
              "Aszune [H]", "Auchindoun [H]", "AzjolNerub [H]", "Azshara [H]", "Azuremyst [H]", "Baelgun [H]",
              "Balnazzar [H]", "Blackhand [H]", "Blackmoore [H]", "Blackrock [H]",
              "Blade'sEdge [H]", "Bladefist [H]", "Bloodfeather [H]", "Bloodhoof [H]", "Bloodscalp [H]",
              "Blutkessel [H]", "Boulderfist [H]", "BronzeDragonflight [H]", "Bronzebeard [H]",
              "BurningBlade [H]", "BurningLegion [H]", "BurningSteppes [H]", "C'Thun [H]", "ChamberofAspects [H]",
              "Chantséternels [H]", "Cho'gall [H]", "Chromaggus [H]", "ColinasPardas [H]",
              "ConfrérieduThorium [H]", "ConseildesOmbres [H]", "Crushridge [H]", "CultedelaRivenoire [H]",
              "Daggerspine [H]", "Dalaran [H]", "Dalvengyr [H]", "DarkmoonFaire [H]",
              "Darksorrow [H]", "Darkspear [H]", "DasKonsortium [H]", "DasSyndikat [H]", "Deathwing [H]",
              "DefiasBrotherhood [H]", "Dentarg [H]", "DerabyssischeRat [H]", "DerMithrilorden [H]",
              "DerRatvonDalaran [H]", "Destromath [H]", "Dethecus [H]", "DieAldor [H]", "DieArguswacht [H]",
              "DieewigeWacht [H]", "DieNachtwache [H]", "DieSilberneHand [H]", "DieTodeskrallen [H]",
              "Doomhammer [H]", "Draenor [H]", "Dragonblight [H]", "Dragonmaw [H]", "Drak'thul [H]", "Drek'Thar [H]",
              "DunModr [H]", "DunMorogh [H]", "Dunemaul [H]", "Durotan [H]",
              "EarthenRing [H]", "Echsenkessel [H]", "Eitrigg [H]", "Eldre'Thalas [H]", "Elune [H]", "EmeraldDream [H]",
              "Emeriss [H]", "Eonar [H]", "Eredar [H]", "Executus [H]", "Exodar [H]",
              "FestungderStürme [H]", "Forscherliga [H]", "Frostmane [H]", "Frostmourne [H]", "Frostwhisper [H]",
              "Frostwolf [H]", "Garona [H]", "Garrosh [H]", "Genjuros [H]", "Ghostlands [H]",
              "Gilneas [H]", "Gorgonnash [H]", "GrimBatol [H]", "Gul'dan [H]", "Hakkar [H]", "Haomarush [H]",
              "Hellfire [H]", "Hellscream [H]", "Hyjal [H]", "Illidan [H]", "Jaedenar [H]",
              "Kael'thas [H]", "Karazhan [H]", "Kargath [H]", "Kazzak [H]", "Kel'Thuzad [H]", "Khadgar [H]",
              "KhazModan [H]", "Khaz'goroth [H]", "Kil'jaeden [H]", "Kilrogg [H]", "KirinTor [H]",
              "Kor'gall [H]", "Krag'jin [H]", "Krasus [H]", "KulTiras [H]", "KultderVerdammten [H]",
              "LaCroisadeécarlate [H]", "LaughingSkull [H]", "LesClairvoyants [H]", "LesSentinelles [H]",
              "Lightbringer [H]", "Lightning'sBlade [H]", "Lordaeron [H]", "LosErrantes [H]", "Lothar [H]",
              "Madmortem [H]", "Magtheridon [H]", "Mal'Ganis [H]", "Malfurion [H]", "Malorne [H]",
              "Malygos [H]", "Mannoroth [H]", "MarécagedeZangar [H]", "Mazrigos [H]", "Medivh [H]", "Minahonda [H]",
              "Moonglade [H]", "Mug'thol [H]", "Nagrand [H]", "Nathrezim [H]", "Naxxramas [H]",
              "Nazjatar [H]", "Nefarian [H]", "Nemesis [H]", "Neptulon [H]", "Nera'thor [H]", "Ner'zhul [H]",
              "Nethersturm [H]", "Nordrassil [H]", "Norgannon [H]", "Nozdormu [H]", "Onyxia [H]",
              "Outland [H]", "Perenolde [H]", "PozzoDell'Eternità [H]", "Proudmoore [H]", "Quel'Thalas [H]",
              "Ravencrest [A]", "Rajaxx [H]", "Rashgarroth [H]", "Ravencrest [H]", "Ravenholdt [H]",
              "Rexxar [H]", "Runetotem [H]", "Sanguino [H]", "Sargeras [H]", "Saurfang [H]", "ScarshieldLegion [H]",
              "Sen'jin [H]", "Shadowsong [H]", "ShatteredHalls [H]", "ShatteredHand [H]",
              "Shattrath [H]", "Shen'dralar [H]", "Silvermoon [H]", "Sinstralis [H]", "Skullcrusher [H]",
              "Spinebreaker [H]", "Sporeggar [H]", "SteamwheedleCartel [H]", "Stormrage [H]", "Stormreaver [H]",
              "Stormscale [H]", "Sunstrider [H]", "Suramar [H]", "Sylvanas [H]", "Taerar [H]", "Talnivarr [H]",
              "TarrenMill [H]", "Teldrassil [H]", "Templenoir [H]", "Terenas [H]", "Terokkar [H]",
              "Terrordar [H]", "TheMaelstrom [H]", "TheSha'tar [H]", "TheVentureCo [H]", "Theradras [H]", "Thrall [H]",
              "Throk'Feroth [H]", "Thunderhorn [H]", "Tichondrius [H]", "Tirion [H]",
              "Todeswache [H]", "Trollbane [H]", "Turalyon [H]", "Twilight'sHammer [H]", "TwistingNether [H]",
              "Tyrande [H]", "Uldaman [H]", "Ulduar [H]", "Uldum [H]", "Un'Goro [H]", "Varimathras [H]",
              "Vashj [H]", "Vek'lor [H]", "Vek'nilash [H]", "Vol'jin [H]", "Wildhammer [H]", "Wrathbringer [H]",
              "Xavius [H]", "Ysera [H]", "Ysondre [H]", "Zenedar [H]", "ZirkeldesCenarius [H]",
              "Zul'jin [H]", "Zuluhed [H]", "Азурегос [H]", "Борейскаятундра [H]", "ВечнаяПесня [H]", "Галакронд [H]",
              "Голдринн [H]", "Гордунни [H]", "Гром [H]", "Дракономор [H]", "Король-лич [H]",
              "ПиратскаяБухта [H]", "Подземье [H]", "Разувий [H]", "Ревущийфьорд [H]", "СвежевательДуш [H]",
              "Седогрив [H]", "СтражСмерти [H]", "Термоштепсель [H]", "ТкачСмерти [H]", "ЧерныйШрам [H]",
              "Ясеневыйлес [H]", "Ragnaros [H]"],
        }
    },

    methods: {
        showPayments(faction) {
            axios
            .get('/payments/' + faction)
            .then ((response) => {
                this.items = response.data
                this.actualFaction = faction;
            })
            .catch(error => console.log(error));
        },
        sendPayment(item) {
            this.loading = true;
            //if (item.pre_balance >= item.paying) {
                axios
                .post('/payments/save', {
                    item: item,
                })
                .then ((response) => {
                    console.log(response)
                    this.loading = false;
                    if (response.data == 'wrongvalue') {
                        this.snackbar = true;
                    } else {
                        this.showPayments(this.actualFaction);
                    }
                })
                .catch(function (error) {
                    this.loading = false;
                    console.log(error);
                });
            // } else {
            //     this.snackbarBadValue = true;
            // }
        },
        getPaymentsRealm() {
            axios
            .get('/payments/getPaymentsRealm/'+ this.selectedRealm)
            .then((response) => {
                console.log(response.data[0].total);
                this.realmItems = response.data
                this.realmItems[0].total = this.realmItems[0].total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            })
            .catch(error => console.log(error));
        }
    },


    beforeMount () {
        this.showPayments('all');
    }
  }
</script>
