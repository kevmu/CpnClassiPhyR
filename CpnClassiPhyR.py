#!/usr/bin/python


import collections
import json
import re
import os
import sys
from Bio import SeqIO
from Bio import Seq
from bandwagon import BandsPattern, BandsPatternsSet, custom_ladder, LADDER_100_to_4k

# Need to set matplotlib to use 'Agg' so that xwindows is not active and gel images can be generated.
import matplotlib
matplotlib.use('Agg')

# CpnClassiPhyR - Classification of Phytoplasma Cpn60 sequences using insilico RFLP analysis
class CpnClassiPhyR():

    
    def __init__(self):
        
        #print("Initializing CpnClassiPhyR.....")
        
        # Restriction enzymes and restriction site sequences used in the insilico RFLP digests.
        self.renzymes = {
            'AluI': r'(AG)(CT)', # 'AluI': 'AG^CT', # pos 2
            'BfaI': r'(C)(TAG)', # 'BfaI': 'C^TAG', # pos 1
            # 'DraI': r'(TTT)(AAA)', # DraI: 'TTT^AAA', # pos 3
#            'Bce3081I': r'(T)(AGGAG)', # 'Bce3081I': 'T^AGGAG', # pos 1
#            'Cje263IV': r'([ATCG][ATCG][ATCG][ATCG][ATCG][ATCG][ATCG][ATCG][ATCG][ATCG]G)(AGTTTTGGT[ATCG][ATCG][ATCG][ATCG][ATCG][ATCG][ATCG][ATCG][ATCG][ATCG])', # 'Cje263IV': 'G^AGTTTTGGT', # pos 1
            'HinfI': r'(G)(A[ATCG]TC)', # 'HinfI': 'G^ANTC', # pos 1
            'HpaI': r'(GTT)(AAC)', # 'HpaI': 'GTT^AAC', # pos 3
            'MseI': r'(T)(TAA)', # 'MseI': 'T^TAA', # pos 1
            'RsaI': r'(GT)(AC)', # 'RsaI': 'GT^AC', # pos 2
            'TaqI': r'(T)(CGA)' # 'TaqI': 'T^CGA', # pos 1
        }

#    def rsites(self):
#        rsites = {}
#        for renzyme in sorted(self.renzymes):
#            temp = self.renzymes[renzyme].replace(")(", "^").replace(")","").replace("(", "")
#            
#            print(temp)


    def RFLP_digest(self, seq):

        seq = seq.upper()

        digest_metadata = {}
        for renzyme in sorted(self.renzymes):
            rsite_regex = self.renzymes[renzyme]
            digested_seq = re.sub(rsite_regex, r'\1 \2', seq).split(' ')
            digest_metadata[str((renzyme, 'fragments'))] = digested_seq
            digest_metadata[str((renzyme, 'num_bands'))] = len(digested_seq)
            band_sizes = []
            for fragments in digested_seq:
               band_sizes.append(len(fragments))
            digest_metadata[str((renzyme, 'band_sizes'))] = band_sizes


        return digest_metadata



    def RFLP_digests(self, fasta_infile):
        RFLP_digests = {}
        for fasta_record in SeqIO.parse(fasta_infile, "fasta"):

            id = str(fasta_record.id)
            sequence = str(fasta_record.seq)
            desc = str(fasta_record.description)
            
            digest_metadata = self.RFLP_digest(sequence)
            digest_metadata['id'] = id
            digest_metadata['desc'] = desc
            digest_metadata['raw_sequence'] = sequence
            digest_metadata['raw_seq_length'] = len(sequence)
            

            digest_metadata['amino_acid_sequence'] = Seq.translate(sequence, table='Standard', stop_symbol='*', to_stop=False, cds=False, gap=None)
            digest_metadata['amino_acid_seq_length'] = len(digest_metadata['amino_acid_sequence'])
            RFLP_digests[id] = digest_metadata
        return RFLP_digests
    
    
    
#    def common_band_count(self, band_size_list1, band_size_list2):
#        
#        common_bands = 0
#        i = 0
#        while(i < len(band_size_list2)):
#            j = 0
#            while(j < len(band_size_list1)):
#                if(band_size_list2[i] == band_size_list1[j]):
#                    common_bands += 1
#                j += 1
#            i += 1
#            
#        return common_bands

    def common_band_count(self, band_size_list1, band_size_list2):

        sorted_band_size_list1 = sorted(band_size_list1)
        sorted_band_size_list2 = sorted(band_size_list2)
#        print(sorted_band_size_list1)
#        print(sorted_band_size_list2)


        band_size_list_queue = collections.deque()
        band_size_list_queue.extend(sorted_band_size_list1)
        band_size_list = sorted_band_size_list2

        common_bands = 0
        i = 0
        while(i < len(band_size_list)):
            try:
                band_size = band_size_list_queue.popleft()
            except IndexError:
                break
            
            
            if(band_size == band_size_list[i]):
                common_bands += 1
                i += 1
            

            elif(band_size < band_size_list[i]):
                continue
            elif(band_size > band_size_list[i]):
                curr = i
                while(curr < len(band_size_list)):
                    if(band_size == band_size_list[curr]):
                        common_bands += 1
                        i = curr + 1
                        break
#                    if(i < len(band_size_list)):
                    curr += 1
#                i = curr

        
                
                
        


#        print(common_bands)
        return common_bands



#    def common_band_count(self, band_size_list1, band_size_list2):
#
#        sorted_band_size_list1 = sorted(band_size_list1)
#        sorted_band_size_list2 = sorted(band_size_list2)
#        print(sorted_band_size_list1)
#        print(sorted_band_size_list2)
#        
#        
#        band_size_list_queue = collections.deque()
#        band_size_list = []
#        if(len(sorted_band_size_list2) >= len(sorted_band_size_list1)):
#            band_size_list_queue = collections.deque()
#            band_size_list_queue.extend(sorted_band_size_list1)
#            band_size_list = sorted_band_size_list2
#            print(band_size_list_queue)
#        elif(len(sorted_band_size_list2) < len(sorted_band_size_list1)):
#            band_size_list_queue.extend(sorted_band_size_list2)
#            band_size_list = sorted_band_size_list1
#            print(band_size_list_queue)
#
#        common_bands = 0
#        i = 0
#        while(True):
#            try:
#                band_size = band_size_list_queue.popleft()
#            except IndexError:
#                break
#            while(i < len(band_size_list)):
#                if(band_size == band_size_list[i]):
#                    common_bands += 1
##                    i += 1
#                    break
#    
#                i += 1
#
#        print(common_bands)
#        return common_bands
#        sys.exit()
#        common_bands = 0
#        i = 0
#        while(i < len(band_size_list2)):
#            j = 0
#            while(j < len(band_size_list1)):
#                if(band_size_list2[i] == band_size_list1[j]):
#                    common_bands += 1
#                j += 1
#            i += 1
#
#        return common_bands


    def calc_similarity_coefficient(self, RFLP_digest1, RFLP_digest2):
        similarity_coefficient = {}
#        common_bands = {}
        Nx = 0
        Ny = 0
        Nxy = 0
        for renzyme in sorted(self.renzymes):
#            print(RFLP_digest1[str((renzyme,'band_sizes'))])
#            print(RFLP_digest2[str((renzyme,'band_sizes'))])
#            
#            common_bands[str((renzyme,'common_bands'))] = self.common_band_count(RFLP_digest1[str((renzyme,'band_sizes'))], RFLP_digest2[str((renzyme,'band_sizes'))])
#            
#            print(common_bands[str((renzyme,'common_bands'))])
            Nx += RFLP_digest1[str((renzyme,'num_bands'))]
            Ny += RFLP_digest2[str((renzyme,'num_bands'))]
#            print(renzyme)
            Nxy += self.common_band_count(RFLP_digest1[str((renzyme,'band_sizes'))], RFLP_digest2[str((renzyme,'band_sizes'))])
        
        # F=2(Nxy)/Nx+Ny
        F = (2 * Nxy) / (Nx + Ny)
#        print(Nxy)
#        print(Nx)
#        print(Ny)
#
#        print(F)
        F_value = '{0:1.2f}'.format(F)
        
        similarity_coefficient['Nx'] = Nx
        similarity_coefficient['Ny'] = Ny
        similarity_coefficient['Nxy'] = Nxy
        similarity_coefficient['F'] = F
        similarity_coefficient['F_value'] = F_value
        
        return similarity_coefficient





    def similarity_coefficient_matrix(self, RFLP_digests):

        similarity_coefficients = {}
        for strain1 in sorted(RFLP_digests):
            for strain2 in sorted(RFLP_digests):
                
#                if(strain2 == strain1):
#                    print("strain2 == strain1")
#                    print(strain2 + " == " + strain1)
#                    # F-Value equals 1
#                    similarity_coefficients[str((strain1,strain2))] = 1.00
#                else:
#                print(strain1)
#                print(strain2)
#                print(RFLP_digests[strain1])
#                print(RFLP_digests[strain2])

                similarity_coefficient_metadata = self.calc_similarity_coefficient(RFLP_digests[strain1], RFLP_digests[strain2])
#                    similarity_coefficients[str((strain1,strain2))] = similarity_coefficient_metadata['F_value']

                similarity_coefficients[str((strain1,strain2))] = similarity_coefficient_metadata
#                print(similarity_coefficients[str((strain1,strain2))])
#        sys.exit()
        return similarity_coefficients




    def draw_gel(self,digest_metadata,xlabel,output_dir):
        strain_name = digest_metadata['id']
        cpn60UT_ladder = custom_ladder("cpn60UT", {
                                       25: 250,
                                       50: 225,
                                       100: 205,
                                       200: 186,
                                       300: 171,
                                       400: 158,
                                       500: 149,
                                       600: 139
                                       })
        LADDER_100_to_1k  = custom_ladder("cpn60UT", {
                                          
            25: 249,
            50: 226,
            100: 205,
            200: 186,
            300: 171,
            400: 158,
            500: 149,
            650: 139,
            850: 128,
            1000: 121
        })
#        ladder = cpn60UT_ladder.modified(background_color="#E2EDFF", label_fontdict={"rotation": -90}, label="MW")
        ladder = LADDER_100_to_1k.modified(background_color="#E2EDFF", label_fontdict={"rotation": -90}, label="MW")
        patterns = []
        for renzyme in sorted(self.renzymes):
            patterns.append(BandsPattern(digest_metadata[str((renzyme, 'band_sizes'))], ladder, label_fontdict={"rotation": -90}, label=renzyme))
        #    patterns_set = BandsPatternsSet(patterns=[ladder] + patterns, ladder=ladder, label_fontdict={"size": 7}, label="Migration Distance", ladder_ticks=3)
        patterns_set = BandsPatternsSet(patterns=[ladder] + patterns, ladder=ladder, ladder_ticks=3)
        ax = patterns_set.plot()
        ax.set_xlabel(xlabel)
        outfile = os.path.join(output_dir, strain_name + ".png")
        if not os.path.exists(outfile):
            ax.figure.savefig(outfile, bbox_inches="tight", dpi=600)

        return outfile



