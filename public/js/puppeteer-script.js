const puppeteer = require("puppeteer");

(async () => {
  const browser = await puppeteer.launch({ headless: true });
  const page = await browser.newPage();

  await page.goto("https://sso.bps.go.id/auth/realms/pegawai-bps/protocol/openid-connect/auth?client_id=account");

  await page.type("#username", "faiz.fathur");
  await page.type("#password", "Tupaikeren21");
  await page.click("button[type=submit]");

  await page.waitForNavigation();
  console.log("Login berhasil!");

  await browser.close();
})(); 