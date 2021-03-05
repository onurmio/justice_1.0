db.createUser(
    {
        user: "root",
        pwd: "root",
        roles: [ 
            { role: "userAdminAnyDatabase", db: "justice" }, { role: "dbAdminAnyDatabase", db: "justice" }, { role: "readWriteAnyDatabase", db: "justice" }
        ]
    });

    