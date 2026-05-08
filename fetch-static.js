const axios = require('axios');
const fs = require('fs');
const path = require('path');

async function copyRecursiveSync(src, dest) {
    const exists = fs.existsSync(src);
    const stats = exists && fs.statSync(src);
    const isDirectory = exists && stats.isDirectory();
    if (isDirectory) {
        if (!fs.existsSync(dest)) {
            fs.mkdirSync(dest, { recursive: true });
        }
        fs.readdirSync(src).forEach(childItemName => {
            copyRecursiveSync(path.join(src, childItemName), path.join(dest, childItemName));
        });
    } else {
        fs.copyFileSync(src, dest);
    }
}

async function exportStatic() {
    const port = 9400; 
    const baseUrl = `http://127.0.0.1:${port}`;
    const distDir = path.join(__dirname, 'dist');

    const pages = [
        { url: '/', file: 'index.html' },
        { url: '/booking/', file: 'booking/index.html' },
        { url: '/jab-we-talk/', file: 'jab-we-talk/index.html' },
        { url: '/life-coaching/', file: 'life-coaching/index.html' },
        { url: '/mentoring/', file: 'mentoring/index.html' },
        { url: '/walks-wellness-more/', file: 'walks-wellness-more/index.html' },
        { url: '/courses/', file: 'courses/index.html' },
        { url: '/digital-products/', file: 'digital-products/index.html' },
        { url: '/workshops/', file: 'workshops/index.html' }
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
                console.log(`  Fetching: ${currentUrl}`);
                response = await axios.get(currentUrl, {
                    maxRedirects: 0,
                    validateStatus: (status) => status < 500,
                    headers: {
                        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                        'Cookie': cookieString
                    }
                });

                console.log(`  Response: ${response.status}`);

                if (response.headers['set-cookie']) {
                    response.headers['set-cookie'].forEach(c => {
                        const [pair] = c.split(';');
                        const [key, val] = pair.split('=');
                        if (key) cookieMap.set(key.trim(), val ? val.trim() : '');
                    });
                }

                if (response.status >= 300 && response.status < 400 && response.headers.location) {
                    let nextUrl = response.headers.location;
                    if (!nextUrl.startsWith('http')) {
                        nextUrl = baseUrl + (nextUrl.startsWith('/') ? '' : '/') + nextUrl;
                    }
                    
                    console.log(`  Redirecting to: ${nextUrl}`);
                    if (nextUrl === currentUrl) {
                        if (page.url === '/' && !currentUrl.endsWith('index.php')) {
                            console.log('  Self-loop detected on root, trying /index.php fallback...');
                            currentUrl = baseUrl + '/index.php';
                            continue;
                        }
                        break;
                    }
                    currentUrl = nextUrl;
                    redirectCount++;
                } else {
                    break;
                }
            }

            let html = response.data;
            if (response.status === 200 && html) {
                // Fix paths: replace the local base URL with relative paths or root-relative
                // We'll use root-relative paths for simplicity as it works on most static hosts
                html = html.replace(new RegExp(baseUrl, 'g'), '');
                
                // Fix for CSS/JS paths that might be missing the leading slash or have localhost hardcoded
                html = html.replace(/http:\/\/localhost:9400/g, '');
                html = html.replace(/http:\/\/127.0.0.1:9400/g, '');
                
                const filePath = path.join(distDir, page.file);
                fs.mkdirSync(path.dirname(filePath), { recursive: true });
                fs.writeFileSync(filePath, html);
                console.log(`Saved ${page.file} (${html.length} bytes)`);
            } else {
                console.warn(`Warning: Failed to get content for ${page.url}. Status: ${response.status}`);
            }
        } catch (err) {
            console.error(`Failed to fetch ${page.url}:`, err.message);
        }
    }

    // Copy assets
    console.log('Copying assets...');
    const themeTarget = path.join(distDir, 'wp-content', 'themes', 'akela-mann');
    const themeSrc = path.join(__dirname, 'theme', 'akela-mann');
    if (fs.existsSync(themeSrc)) copyRecursiveSync(themeSrc, themeTarget);
    const imagesSrc = path.join(__dirname, 'images');
    if (fs.existsSync(imagesSrc)) copyRecursiveSync(imagesSrc, path.join(distDir, 'images'));

    console.log('--- Export Complete ---');
}

exportStatic().catch(console.error);
