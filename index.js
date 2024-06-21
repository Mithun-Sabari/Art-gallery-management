const sql=require("mssql/msnodesqlv8");
var config={
    server :"LAPTOP-HR4VSQO5\\SQLEXPRESS",
    database : "dbms",
    driver : "msnodesqlv8",
    connectionString: 'DSN=SQL server;UID=sa;PWD=12345678',
    user : "sa",
    password:"12345678",
    options :{
        trustedConnection: true
    }
}

sql.connect(config,function(err){
    if(err)console.log(err);
    var request=new sql.Request();
    request.query("select * from names",function(err,records){
        if(err)console.log(err);
        else console.log(records); 
})
}
)
