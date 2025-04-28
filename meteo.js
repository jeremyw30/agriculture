const axios = require('axios');
const cheerio = require('cheerio');
const fs = require('fs');

const annee = '2023';
const moisList = [
  'janvier', 'fevrier', 'mars', 'avril', 'mai', 'juin',
  'juillet', 'aout', 'septembre', 'octobre', 'novembre', 'decembre'
];

const moisIndex = {
  janvier: '01', fevrier: '02', mars: '03', avril: '04',
  mai: '05', juin: '06', juillet: '07', aout: '08',
  septembre: '09', octobre: '10', novembre: '11', decembre: '12'
};

const delay = (ms) => new Promise(resolve => setTimeout(resolve, ms));

async function scrapeMois(mois) {
  const url = `https://www.historique-meteo.net/france/aquitaine/bordeaux/${annee}/${mois}/`;
  console.log(`🔍 Scraping ${mois} ${annee}...`);
  try {
    const { data } = await axios.get(url);
    const $ = cheerio.load(data);
    const results = [];

    $('table.table.table-striped tbody tr').each((i, row) => {
      const cols = $(row).find('td');
      const jour = $(cols[0]).text().trim();
      const tempMax = $(cols[1]).text().trim();
      const tempMin = $(cols[2]).text().trim();
      const pluie = $(cols[3]).text().trim();
      const vent = $(cols[4]).text().trim();
      const humidite = $(cols[5]).text().trim();

      if (jour && jour.length <= 2) {
        const date = `${annee}-${moisIndex[mois]}-${jour.padStart(2, '0')}`;
        results.push({
          date,
          temp_max: tempMax,
          temp_min: tempMin,
          pluie_mm: pluie,
          vent_kmh: vent,
          humidite_percent: humidite
        });
      }
    });

    return results;
  } catch (err) {
    console.error(`❌ Erreur pendant le scraping de ${mois} :`, err.message);
    return [];
  }
}

async function scrapeAnneeComplete() {
  let fullData = [];

  for (const mois of moisList) {
    const data = await scrapeMois(mois);
    fullData = fullData.concat(data);
    await delay(1500); // pause pour éviter de surcharger le serveur
  }

  fs.writeFileSync(`meteo-bordeaux-${annee}.json`, JSON.stringify(fullData, null, 2));
  console.log(`✅ Données météo complètes pour Bordeaux ${annee} sauvegardées dans meteo-bordeaux-${annee}.json`);
}

scrapeAnneeComplete();