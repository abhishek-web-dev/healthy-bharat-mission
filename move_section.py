import re

with open("program.html", "r") as f:
    content = f.read()

# Find the Impact/Stats Section
impact_start = content.find("        <!-- Impact/Stats Section -->")
impact_end = content.find("        <!-- Our Programs Section -->")

if impact_start != -1 and impact_end != -1:
    impact_section = content[impact_start:impact_end]
    # Remove impact section from its original place
    content = content[:impact_start] + content[impact_end:]
    
    # Find the end of Our Programs Section
    # It ends before </main>
    main_end = content.find("    </main>")
    if main_end != -1:
        # Insert impact section before </main>
        content = content[:main_end] + impact_section + content[main_end:]
        
        with open("program.html", "w") as f:
            f.write(content)
        print("Success")
    else:
        print("Could not find </main>")
else:
    print("Could not find sections")

