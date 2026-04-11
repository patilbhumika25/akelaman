const axios = require('axios');
const fs = require('fs');
const path = require('path');
const { spawn, execSync } = require('child_process');

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
    const port = 9500; // Use a different port to avoid conflicts
    const baseUrl = `http://127.0.0.1:${port}`;
    const distDir = path.join(__dirname, 'dist');
    const blueprint = fs.existsSync(path.join(__dirname, 'blueprint-no-login.json')) 
        ? 'blueprint-no-login.json' 
        : 'blueprint.json';

    console.log('--- Starting WordPress Server ---');
    
    // Start server
    const server = spawn(process.platform === 'win32' ? 'npx.cmd' : 'npx', [
        '-y', '@wp-playground/cli', 'server', 
        '--port', port.toString(),
        '--blueprint', blueprint,
        '--mount-dir', path.join(__dirname, 'theme', 'akela-mann'), '/wordpress/wp-content/themes/akela-mann',
        '--mount-dir', path.join(__dirname, 'plugin'), '/wordpress/wp-content/plugins/akela-mann-plugin'
    ], { shell: true });

    // Wait for server to be ready
    await new Promise((resolve, reject) => {
        let output = '';
        server.stdout.on('data', (data) => {
            output += data.toString();
            if (output.includes('Ready!')) {
                console.log('Server is ready. Waiting 5 seconds for initialization...');
                setTimeout(resolve, 5000);
            }
        });
        server.stderr.on('data', (data) => {
            console.error(`[SERVER ERR] ${data}`);
        });
        setTimeout(() => reject(new Error('Server timeout')), 120000);
    });

    const pages = [
        { url: '/index.php?static_export=1', file: 'index.html' },
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
            const maxRedirects = 5;
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

                // Capture cookies
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
                        console.warn(`  Self-loop detected at ${currentUrl}`);
                        break;
                    }
                    currentUrl = nextUrl;
                    redirectCount++;
                } else {
                    break;
                }
            }

            let html = response.data;
            if (!html || response.status !== 200) {
                console.warn(`Warning: Failed to get content for ${page.url}. Status: ${response.status}`);
            } else {
                // Fix paths
                html = html.replace(new RegExp(baseUrl, 'g'), '');
                const filePath = path.join(distDir, page.file);
                fs.mkdirSync(path.dirname(filePath), { recursive: true });
                fs.writeFileSync(filePath, html);
                console.log(`Saved ${page.file} (${html.length} bytes)`);
            }
        } catch (err) {
            console.error(`Failed to fetch ${page.url}:`, err.message);
        }
    }

    // Copy assets
    console.log('Copying assets...');
    
    // Copy theme assets
    const themeTarget = path.join(distDir, 'wp-content', 'themes', 'akela-mann');
    const themeSrc = path.join(__dirname, 'theme', 'akela-mann');
    if (fs.existsSync(themeSrc)) {
         copyRecursiveSync(themeSrc, themeTarget);
    }

    // Copy root images
    const imagesSrc = path.join(__dirname, 'images');
    if (fs.existsSync(imagesSrc)) {
        copyRecursiveSync(imagesSrc, path.join(distDir, 'images'));
    }

    console.log('--- Cleaning Up ---');
    server.kill();
    console.log('--- Export Complete ---');
    process.exit(0);
}

exportStatic().catch(err => {
    console.error('Fatal error during export:', err);
    process.exit(1);
});
