({
    appDir: "../",
    
    mainConfigFile: './main.js',
    
    baseUrl: "js",
    
    dir: "../../build",
    
    optimize: "uglify",
    
    generateSourceMaps: false,

    modules: [
        {
            name: "main",

            include: [
                "app"
            ]
        }
    ]
})
