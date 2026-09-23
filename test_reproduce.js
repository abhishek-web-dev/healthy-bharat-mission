const puppeteer = require('puppeteer');

(async () => {
    try {
        const browser = await puppeteer.launch({ headless: 'new' });
        const page = await browser.newPage();
        
        page.on('console', msg => console.log('PAGE LOG:', msg.text()));
        
        await page.goto('http://localhost:8080/auth/login');
        await page.waitForSelector('input[type="email"]');
        
        await page.type('input[type="email"]', 'admin@healthybharatmission.com');
        await page.type('input[placeholder="Enter your password"]', 'Admin@123');
        await page.click('button[type="submit"]');
        
        await page.waitForNavigation({ waitUntil: 'networkidle0' });
        console.log('Current URL after login:', page.url());
        
        let token = await page.evaluate(() => localStorage.getItem('hbm_token'));
        console.log('Token in localStorage:', token);
        
        // Go to dashboard
        await page.goto('http://localhost:8080/dashboard/index', { waitUntil: 'networkidle0' });
        console.log('Current URL after dashboard navigation:', page.url());
        
        token = await page.evaluate(() => localStorage.getItem('hbm_token'));
        console.log('Token in localStorage:', token);
        
        await browser.close();
    } catch (e) {
        console.error(e);
    }
})();
