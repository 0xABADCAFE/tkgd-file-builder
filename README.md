# tkgd-file-builder

MVP tooling for building TKGD modification files for AB3D2, implemented in PHP.

## MakeGameProperties

This tool parses an ARSON formatted description of the main game modification, as described [here](https://github.com/mheyer32/alienbreed3d2/blob/main/docs/extended_modding/source/GameModification.md).

### Usage

The tool takes three parameters:

- `-b` Specifies the base location for the modification source files.
- `-f` Specifies the specific ARSON file to use.
    - All relative paths within an ARSON file are relative to this location.
    
- `-g` Specifies the installation location of the game
    - The compilation `Target` path within the ARSON file is relative to this location.

```
./MakeGameProperties -b <source base location> -f <source file name> -g <game base location>
```



## MakeLevelProperties

This tool parses an ARSON formatted description of a level modification, as described [here](https://github.com/mheyer32/alienbreed3d2/blob/main/docs/extended_modding/source/LevelModification.md).

### Usage

The tool takes three parameters:

- `-b` Specifies the base location for the modification source files.
    - All relative paths within an ARSON file are relative to this location.
    
- `-f` Specifies the specific ARSON file to use.
- `-g` Specifies the installation location of the game
    - The compilation `Target` path within the ARSON file is relative to this location.



### Usage

```
./MakeLevelProperties -b <source base location> -f <source file name> -g <game base location>
```

