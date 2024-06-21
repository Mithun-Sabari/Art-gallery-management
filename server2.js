const sql = require('mssql/msnodesqlv8');

const config = {
    driver: 'msnodesqlv8',
    server: 'LAPTOP-HR4VSQO5\\SQLEXPRESS',
    database: 'dbms',
    user : 'sa',
    connectionString: 'DSN=SQL server;UID=sa;PWD=12345678',
    password : '12345678',
    options: {
        trustedConnection: true // Use true if using Windows Authentication
    }
};

sql.connect(config).then(pool => {
    return pool.request().query('SELECT * from names');
}).then(result => {
    console.log(result);
}).catch(err => {
    console.error(err);
});
