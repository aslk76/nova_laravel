<template>
<v-app :dark="true">
    <div>
        <div style="text-align: center">
            <v-btn
                elevation="6"
                fab
                large
                tile
                text
                style="color: red; font-size: 10px;"
                @click="showHordeRuns()"
            >HORDE</v-btn>
            <v-divider vertical style="padding: 5px;"></v-divider>
            <v-btn
                elevation="6"
                fab
                large
                text
                tile
                style="color:blue; font-size: 10px;"
                @click="showAllianceRuns()"
            >ALLIANCE</v-btn>
            <v-divider vertical style="padding: 5px;"></v-divider>
            <v-btn
                elevation="6"
                fab
                large
                tile
                text
                style="color:black; font-size: 10px;"
                @click="getItems()"
            >ALL</v-btn>
            </div>
            <!-- <v-select class="weekSelector"
                v-model="selectedWeek"
                :items="weeks"
                item-text="week"
                item-value="id"
                label="Week"
                single-line
                return-object
            ></v-select> -->
        <v-card-title>
        <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search for Boost Realm"
            single-line
            hide-details
        ></v-text-field>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="items"
            :items-per-page="5"
            :search="search"
            class="elevation-1"
            @click:row="showDialog"
        >
        <template v-slot:item.collected="{ item }">
            <v-simple-checkbox
            v-model="item.collected"
            enabled
            @click="onCheckboxClicked(item, 'collected', item.collected)"
            ></v-simple-checkbox>
        </template>
        <template v-slot:item.missing="{ item }">
            <v-simple-checkbox
            v-model="item.missing"
            enabled
            @click="onCheckboxClicked(item, 'missing', item.missing)"
            ></v-simple-checkbox>
        </template>
        </v-data-table>
        <template>
        <v-dialog v-model="dialog">
            <v-card class="mx-auto">
                <v-app-bar color="blue-grey lighten-5" dense>
                    <v-toolbar-title class="ml-3 menutitle">
                        <v-btn elevation="2" fab x-small class="save-button-dialog" color="blue-grey lighten-5" @click="saveRunMplus(itemsFromDialog)">
                            <span class="material-icons">
                                save
                            </span>
                        </v-btn>
                        <v-btn elevation="2" fab x-small class="close-button-dialog" color="blue-grey lighten-5" @click="dialog = false">
                            <span class="material-icons">
                                close
                            </span>
                        </v-btn>
                        <span class="ml-5">
                            Edit Run
                        </span>
                    </v-toolbar-title>
                </v-app-bar>
                <div class="data-table-dialog">
                    <v-data-table
                        :headers="headersFromDialog"
                        :items="itemsFromDialog"
                        :items-per-page="1"
                        :search="search"
                        class="elevation-1"
                    >
                <template v-slot:item.boost_faction="props">
                    <v-edit-dialog
                        :return-value.sync="props.item.boost_faction"
                        large
                        persistent
                    >
                        <div>{{ props.item.boost_faction }}</div>
                        <template v-slot:input>
                            <div class="mt-4 title">
                                Update Boost Faction
                            </div>
                            <v-select
                                v-model="props.item.boost_faction"
                                :items="factions"
                                label="Edit"
                                single-line
                            ></v-select>
                        </template>
                    </v-edit-dialog>
                </template>
                <template v-slot:item.boost_date="props">
                    <v-edit-dialog
                        :return-value.sync="props.item.boost_date"
                        large
                        persistent
                    >
                        <div>{{ props.item.boost_date }}</div>
                        <template v-slot:input>
                            <div class="mt-4 title">
                                Update Boost Date
                            </div>
                            <v-text-field
                                v-model="props.item.boost_date"
                                label="Edit"
                                single-line
                                counter
                                autofocus
                            ></v-text-field>
                        </template>
                    </v-edit-dialog>
                </template>
                <template v-slot:item.boost_realm="props">
                    <v-edit-dialog
                        :return-value.sync="props.item.boost_realm"
                        large
                        persistent
                    >
                        <div>{{ props.item.boost_realm }}</div>
                        <template v-slot:input>
                            <div class="mt-4 title">
                                Update Boost Realm
                            </div>
                            <v-autocomplete
                                v-model="props.item.boost_realm"
                                :items="realms"
                                label="Edit"
                                single-line
                            ></v-autocomplete>
                        </template>
                    </v-edit-dialog>
                </template>
                <template v-slot:item.adv_realm="props">
                    <v-edit-dialog
                        :return-value.sync="props.item.adv_realm"
                        large
                        persistent
                    >
                        <div>{{ props.item.adv_realm }}</div>
                        <template v-slot:input>
                            <div class="mt-4 title">
                                Update Adv Realm
                            </div>
                            <v-autocomplete
                                v-model="props.item.adv_realm"
                                :items="realms"
                                label="Edit"
                                single-line
                            ></v-autocomplete>
                        </template>
                    </v-edit-dialog>
                </template>
                <template v-slot:item.tank_realm="props">
                    <v-edit-dialog
                        :return-value.sync="props.item.tank_realm"
                        large
                        persistent
                    >
                        <div>{{ props.item.tank_realm }}</div>
                        <template v-slot:input>
                            <div class="mt-4 title">
                                Update Tank Realm
                            </div>
                            <v-autocomplete
                                v-model="props.item.tank_realm"
                                :items="realms"
                                label="Edit"
                                single-line
                            ></v-autocomplete>
                        </template>
                    </v-edit-dialog>
                </template>
                <template v-slot:item.healer_realm="props">
                    <v-edit-dialog
                        :return-value.sync="props.item.healer_realm"
                        large
                        persistent
                    >
                        <div>{{ props.item.healer_realm }}</div>
                        <template v-slot:input>
                            <div class="mt-4 title">
                                Update Healer Realm
                            </div>
                            <v-autocomplete
                                v-model="props.item.healer_realm"
                                :items="realms"
                                label="Edit"
                                single-line
                            ></v-autocomplete>
                        </template>
                    </v-edit-dialog>
                </template>
                <template v-slot:item.dps1_realm="props">
                    <v-edit-dialog
                        :return-value.sync="props.item.dps1_realm"
                        large
                        persistent
                    >
                        <div>{{ props.item.dps1_realm }}</div>
                        <template v-slot:input>
                            <div class="mt-4 title">
                                Update DPS1 Realm
                            </div>
                            <v-autocomplete
                                v-model="props.item.dps1_realm"
                                :items="realms"
                                label="Edit"
                                single-line
                            ></v-autocomplete>
                        </template>
                    </v-edit-dialog>
                </template>
                <template v-slot:item.dps2_realm="props">
                    <v-edit-dialog
                        :return-value.sync="props.item.dps2_realm"
                        large
                        persistent
                    >
                        <div>{{ props.item.dps2_realm }}</div>
                        <template v-slot:input>
                            <div class="mt-4 title">
                                Update DPS2 Realm
                            </div>
                            <v-autocomplete
                                v-model="props.item.dps2_realm"
                                :items="realms"
                                label="Edit"
                                single-line
                            ></v-autocomplete>
                        </template>
                    </v-edit-dialog>
                </template>
                <template v-slot:item.boost_pot="props">
                    <v-edit-dialog
                        :return-value.sync="props.item.boost_pot"
                        large
                        persistent
                    >
                        <div>{{ props.item.boost_pot }}</div>
                        <template v-slot:input>
                            <div class="mt-4 title">
                                Update Boost Pot
                            </div>
                            <v-text-field
                                v-model="props.item.boost_pot"
                                label="Edit"
                                single-line
                                counter
                                autofocus
                            ></v-text-field>
                        </template>
                    </v-edit-dialog>
                </template>
                <template v-slot:item.adv_name="props">
                    <v-edit-dialog
                        :return-value.sync="props.item.adv_name"
                        large
                        persistent
                    >
                        <div>{{ props.item.adv_name }}</div>
                        <template v-slot:input>
                            <div class="mt-4 title">
                                Update Adv Name
                            </div>
                            <v-text-field
                                v-model="props.item.adv_name"
                                label="Edit"
                                single-line
                                counter
                                autofocus
                            ></v-text-field>
                        </template>
                    </v-edit-dialog>
                </template>
                <template v-slot:item.adv_cut="props">
                    <v-edit-dialog
                        :return-value.sync="props.item.adv_cut"
                        large
                        persistent
                    >
                        <div>{{ props.item.adv_cut }}</div>
                        <template v-slot:input>
                            <div class="mt-4 title">
                                Update Adv Cut
                            </div>
                            <v-text-field
                                v-model="props.item.adv_cut"
                                label="Edit"
                                single-line
                                counter
                                autofocus
                            ></v-text-field>
                        </template>
                    </v-edit-dialog>
                </template>
                <template v-slot:item.tank_name="props">
                    <v-edit-dialog
                        :return-value.sync="props.item.tank_name"
                        large
                        persistent
                    >
                        <div>{{ props.item.tank_name }}</div>
                        <template v-slot:input>
                            <div class="mt-4 title">
                                Update Tank Name
                            </div>
                            <v-text-field
                                v-model="props.item.tank_name"
                                label="Edit"
                                single-line
                                counter
                                autofocus
                            ></v-text-field>
                        </template>
                    </v-edit-dialog>
                </template>
                <template v-slot:item.tank_cut="props">
                    <v-edit-dialog
                        :return-value.sync="props.item.tank_cut"
                        large
                        persistent
                    >
                        <div>{{ props.item.tank_cut }}</div>
                        <template v-slot:input>
                            <div class="mt-4 title">
                                Update Tank Cut
                            </div>
                            <v-text-field
                                v-model="props.item.tank_cut"
                                label="Edit"
                                single-line
                                counter
                                autofocus
                            ></v-text-field>
                        </template>
                    </v-edit-dialog>
                </template>
            </v-data-table>
            </div>
            </v-card>
        </v-dialog>
        </template>
    </div>
</v-app>
</template>

<script>
  export default {
    data () {
      return {
            dialog: false,
            search: '',
            items: [],
            itemsFromDialog: [],
            factions: ["Horde", "Alliance"],
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
            weeks: [
                { id: 1, week: "This week"},
                { id: 2, week: "Last week"}
            ],
            // selectedWeek: {id: 1, week: "This week"},
            headersFromDialog:  [
              { text: 'ID', value: 'id', filterable: false },
              { text: 'Boost Faction', value: 'boost_faction', filterable: false },
              { text: 'Boost ID', value: 'boost_id', filterable: false },
              { text: 'Boost Date', value: 'boost_date', filterable: false },
              { text: 'Boost Realm', value: 'boost_realm' },
              { text: 'Boost Pot', value: 'boost_pot', filterable: false },
              { text: 'Adv Name', value: 'adv_name', filterable: false },
              { text: 'Adv Realm', value: 'adv_realm', filterable: false },
              { text: 'Adv Cut', value: 'adv_cut', filterable: false },
              { text: 'Tank Name', value: 'tank_name', filterable: false },
              { text: 'Tank Realm', value: 'tank_realm', filterable: false },
              { text: 'Tank Cut', value: 'tank_cut', filterable: false },
          ],
          headers: [
              { text: 'ID', value: 'id', filterable: false },
              { text: 'Boost Faction', value: 'boost_faction', filterable: false },
              { text: 'Boost ID', value: 'boost_id', filterable: false },
              { text: 'Boost Date', value: 'boost_date', filterable: false },
              { text: 'Boost Realm', value: 'boost_realm' },
              { text: 'Boost Pot', value: 'boost_pot', filterable: false },
              { text: 'Adv Name', value: 'adv_name', filterable: false },
              { text: 'Collected', value: 'collected', filterable: false },
              { text: 'Missing', value: 'missing', filterable: false },
          ],
          editingRow: [],
      }
    },

    methods: {
        getItems() {
            axios
            .get('/getAllMissingVarious', { transformResponse: [data => data] })
            .then ((response) => {
                let parsed = JSON.parse(response.data.replace(/"boost_id":(\d+),/g, '"boost_id":"$1",'))
                console.log(parsed)
                this.items = parsed
            })
            .catch(error => console.log(error))
        },
        onCheckboxClicked(item, check, status) {
            axios
            .post('/changeCheckboxVarious', {
                id: item.id,
                check: check,
                status: status
            })
            .then ((response) => {
                console.log(response)
            })
            .catch(error => console.log(error))
            if ((check == 'missing') && (status == false)) {
                const index = this.items.indexOf(item)
                this.items.splice(index, 1)
            }
        },
        showAllianceRuns() {
            axios
            .get('/getAllAllianceMissingVarious', { transformResponse: [data => data] })
            .then ((response) => {
                let parsed = JSON.parse(response.data.replace(/"boost_id":(\d+),/g, '"boost_id":"$1",'))
                console.log(parsed)
                this.items = parsed
            })
            .catch(error => console.log(error))
        },
        showHordeRuns() {
            axios
            .get('/getAllHordeMissingVarious', { transformResponse: [data => data] })
            .then ((response) => {
                let parsed = JSON.parse(response.data.replace(/"boost_id":(\d+),/g, '"boost_id":"$1",'))
                console.log(parsed)
                this.items = parsed
            })
            .catch(error => console.log(error))
        },

        showDialog(row) {
            this.editingRow = row;
            axios
            .get('/getSpecificVarious/' + row.id, { transformResponse: [data => data] })
            .then ((response) => {
                let parsed = JSON.parse(response.data.replace(/"boost_id":(\d+),/g, '"boost_id":"$1",'))
                console.log(parsed)
                this.itemsFromDialog = parsed
            })
            .catch(error => console.log(error))
            this.dialog = true;
        },
        saveRunMplus(item) {
            axios
            .post('/saveRunVarious', {
                item: item,
            })
            .then ((response) => {
                console.log(response)
            })
            .catch(error => console.log(error))
            const index = this.items.indexOf(this.editingRow)
            this.items[index].boost_faction = item[0].boost_faction
            this.items[index].boost_date = item[0].boost_date
            this.items[index].boost_realm = item[0].boost_realm
            this.items[index].boost_pot = item[0].boost_pot
            this.items[index].adv_name = item[0].adv_name

        }

    },

    created () {
        this.getItems();
    }
  }
</script>
