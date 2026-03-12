const axios = require('axios');
const fs = require('fs');
const path = require('path');
const { execSync } = require('child_process');

async function exportStatic() {
    const baseUrl = 'http://127.0.0.1:9400';
    const distDir = path.join(__dirname, 'dist');
    const pages = [
        { url: '/', file: 'index.html' },
        { url: '/reels/', file: 'reels/index.html' },
        { url: '/booking/', file: 'booking/index.html' }
    ];

    console.log('--- Generating Static Export ---');

    if (fs.existsSync(distDir)) {
        fs.rmSync(distDir, { recursive: true, force: true });
    }
    fs.mkdirSync(distDir);

    for (const page of pages) {
        console.log(`Fetching ${page.url}...`);
        try {
            let currentUrl = baseUrl + page.url;
            let response;
            let redirectCount = 0;
            const maxRedirects = 10;
            let cookieMap = new Map();

            while (redirectCount < maxRedirects) {
                const cookieString = Array.from(cookieMap.entries()).map(([k, v]) => `${k}=${v}`).join('; ');
                console.log(`[REQ] ${currentUrl} (Cookies: ${cookieString.length > 50 ? cookieString.substring(0, 50) + '...' : cookieString})`);
                response = await axios.get(currentUrl, {
                    maxRedirects: 0,
                    validateStatus: (status) => status < 500,
                    headers: {
                        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                        'Host': '127.0.0.1:9400',
                        'Cookie': cookieString
                    }
                });

                console.log(`[RES] ${response.status} - Location: ${response.headers.location || 'none'}`);

                // Capture cookies
                if (response.headers['set-cookie']) {
                    response.headers['set-cookie'].forEach(c => {
                        const [pair] = c.split(';');
                        const [key, val] = pair.split('=');
                        if (key) {
                            cookieMap.set(key.trim(), val ? val.trim() : '');
                            console.log(`  Set-Cookie: ${key.trim()}`);
                        }
                    });
                }

                if (response.status >= 300 && response.status < 400 && response.headers.location) {
                    let nextUrl = response.headers.location;
                    if (!nextUrl.startsWith('http')) {
                        nextUrl = baseUrl + (nextUrl.startsWith('/') ? '' : '/') + nextUrl;
                    }
                    console.log(`Redirect [${redirectCount}]: ${currentUrl} -> ${nextUrl}`);
                    
                    if (nextUrl === currentUrl) {
                        console.log('Detected self-redirect loop.');
                        break;
                    }

                    currentUrl = nextUrl;
                    redirectCount++;
                } else {
                    break;
                }
            }

            console.log(`Final Fetch ${page.url} - Status: ${response.status} - Content Length: ${response.data ? response.data.length : 0}`);
            let html = response.data;
            if (!html || html.length === 0) {
                console.warn(`Warning: Fetched empty content for ${page.url}. Status was ${response.status}`);
            }

            // Fix paths: replace absolute local paths with relative or root-relative
            // e.g., http://127.0.0.1:9400/wp-content -> /wp-content
            html = html.replace(new RegExp(baseUrl, 'g'), '');
            
            const filePath = path.join(distDir, page.file);
            fs.mkdirSync(path.dirname(filePath), { recursive: true });
            fs.writeFileSync(filePath, html);
        } catch (err) {
            console.error(`Failed to fetch ${page.url}:`, err.message);
        }
    }

    // Copy assets
    console.log('Copying assets...');
    
    // Create wp-content structure
    const themeTarget = path.join(distDir, 'wp-content', 'themes', 'akela-mann');
    fs.mkdirSync(themeTarget, { recursive: true });

    // Copy theme files
    const themeSrc = path.join(__dirname, 'theme', 'akela-mann');
    if (fs.existsSync(themeSrc)) {
         // Use xcopy on windows or a node copy function
         try {
            execSync(`xcopy "${themeSrc}" "${themeTarget}" /E /I /H /Y /Q`);
         } catch (e) {
            console.log('Theme copy might have failed or partial:', e.message);
         }
    }

    // Copy root images if any
    const imagesSrc = path.join(__dirname, 'images');
    if (fs.existsSync(imagesSrc)) {
        execSync(`xcopy "${imagesSrc}" "${path.join(distDir, 'images')}" /E /I /H /Y /Q`);
    }

    console.log('--- Export Complete ---');
}

exportStatic();
