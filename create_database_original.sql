CREATE TABLE IF NOT EXISTS Media (
    MediaID INT PRIMARY KEY,
    MediaType VARCHAR(6),
    HiddenGemScore FLOAT,
    MinMinutes INT,
    MaxMinutes INT,
    ViewRating VARCHAR(10),
    IMDbScore FLOAT,
    RottenTomatoesScore FLOAT,
    MetacriticScore FLOAT,
    AwardsReceived INT,
    AwardsNominated INT,
    BoxOffice FLOAT,
    ReleaseDate DATE,
    NetflixReleaseDate DATE,
    Summary VARCHAR(500),
    IMDbVotes FLOAT
);

CREATE TABLE IF NOT EXISTS MediaLinks (
    LinkID INT PRIMARY KEY,
    NetflixLink VARCHAR(200),
    IMDBLink VARCHAR(200),
    Image VARCHAR(200),
    Poster VARCHAR(200)
);

CREATE TABLE IF NOT EXISTS MediaTrailer (
    TrailerID INT PRIMARY KEY,
    IMDbTrailer VARCHAR(200),
    TrailerSite VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS Tag (
    TagID INT PRIMARY KEY,
    TagName VARCHAR(150)
);

CREATE TABLE IF NOT EXISTS Actor (
    ActorID INT PRIMARY KEY,
    ActorName VARCHAR(150)
);

CREATE TABLE IF NOT EXISTS Country (
    CountryID INT PRIMARY KEY,
    CountryName VARCHAR(150)
);

CREATE TABLE IF NOT EXISTS ProductionHouse (
    ProductionHouseID INT PRIMARY KEY,
    ProductionHouseName VARCHAR(150)
);

CREATE TABLE IF NOT EXISTS Genre (
    GenreID INT PRIMARY KEY,
    GenreName VARCHAR(150)
);

CREATE TABLE IF NOT EXISTS Writer (
    WriterID INT PRIMARY KEY,
    WriterName VARCHAR(150)
);

CREATE TABLE IF NOT EXISTS Director (
    DirectorID INT PRIMARY KEY,
    DirectorName VARCHAR(150)
);

CREATE TABLE IF NOT EXISTS Language (
    LanguageID INT PRIMARY KEY,
    LanguageName VARCHAR(150)
);

CREATE TABLE IF NOT EXISTS Has_Genre (
    GenreID INT,
    MediaID INT,
    PRIMARY KEY(GenreID, MediaID),
    FOREIGN KEY(GenreID) REFERENCES Genre(GenreID),
    FOREIGN KEY(MediaID) REFERENCES Media(MediaID)
);

CREATE TABLE IF NOT EXISTS Writes (
    WriterID INT,
    MediaID INT,
    PRIMARY KEY(WriterID , MediaID),
    FOREIGN KEY(WriterID) REFERENCES Writer(WriterID),
    FOREIGN KEY(MediaID) REFERENCES Media(MediaID)
);

CREATE TABLE IF NOT EXISTS Directs (
    DirectorID INT,
    MediaID INT,
    PRIMARY KEY(DirectorID, MediaID),
    FOREIGN KEY(DirectorID) REFERENCES Director(DirectorID),
    FOREIGN KEY(MediaID) REFERENCES Media(MediaID)
);

CREATE TABLE IF NOT EXISTS Has_Language (
    LanguageID INT,
    MediaID INT,
    PRIMARY KEY(LanguageID, MediaID),
    FOREIGN KEY(LanguageID) REFERENCES Language(LanguageID),
    FOREIGN KEY(MediaID) REFERENCES Media(MediaID)
);
 
CREATE TABLE IF NOT EXISTS Has_Tag (
    TagID INT,
    MediaID INT,
    PRIMARY KEY(TagID, MediaID),
    FOREIGN KEY(TagID) REFERENCES Tag(TagID),
    FOREIGN KEY(MediaID) REFERENCES Media(MediaID)
);

CREATE TABLE IF NOT EXISTS Acts_In (
    ActorID INT,
    MediaID INT,
    PRIMARY KEY(ActorID, MediaID),
    FOREIGN KEY(ActorID) REFERENCES Actor(ActorID),
    FOREIGN KEY(MediaID) REFERENCES Media(MediaID)
);

CREATE TABLE IF NOT EXISTS Available_In (
    CountryID INT,
    MediaID INT,
    PRIMARY KEY(CountryID, MediaID),
    FOREIGN KEY(CountryID) REFERENCES Country(CountryID),
    FOREIGN KEY(MediaID) REFERENCES Media(MediaID)
);

CREATE TABLE IF NOT EXISTS Produces (
    ProductionHouseID INT,
    MediaID INT,
    PRIMARY KEY(ProductionHouseID, MediaID),
    FOREIGN KEY(ProductionHouseID) REFERENCES ProductionHouse(ProductionHouseID),
    FOREIGN KEY(MediaID) REFERENCES Media(MediaID)
);

CREATE TABLE IF NOT EXISTS Has_Trailer (
    TrailerID INT,
    MediaID INT,
    PRIMARY KEY(TrailerID, MediaID),
    FOREIGN KEY(TrailerID) REFERENCES MediaTrailer(TrailerID),
    FOREIGN KEY(MediaID) REFERENCES Media(MediaID)
);

CREATE TABLE IF NOT EXISTS Has_Link (
    LinkID INT,
    MediaID INT,
    PRIMARY KEY(LinkID, MediaID),
    FOREIGN KEY(LinkID) REFERENCES MediaLinks(LinkID),
    FOREIGN KEY(MediaID) REFERENCES Media(MediaID)
);
